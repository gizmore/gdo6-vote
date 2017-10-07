<?php
namespace GDO\Vote\Method;

use GDO\Core\Method;
use GDO\Core\GDO;
use GDO\Net\GDT_IP;
use GDO\Core\GDT_Response;
use GDO\User\GDO_User;
use GDO\Util\Common;
use GDO\Vote\GDO_VoteTable;
use function React\Promise\race;
use GDO\Core\Application;
use GDO\Core\Website;
/**
 * Vote on an item.
 * Check for IP duplicates.
 * @author gizmore
 */
final class Up extends Method
{
	public function execute()
	{
		$user = GDO_User::current();
		
		# Get VoteTable, e.g. LinkVote
		$class= Common::getRequestString('gdo');
		if (!@class_exists($class))
		{
			return $this->error('err_vote_gdo');
		}
		if (!is_subclass_of($class, 'GDO\Vote\GDO_VoteTable'))
		{
			return $this->error('err_vote_table');
		}
		$table = GDO::tableFor($class);
		$table instanceof GDO_VoteTable;
		
		# Get GDO table, e.g. Link
		$objects = $table->gdoVoteObjectTable();
		$objects instanceof GDO;
		
		# Get GDO row, e.g. Link
		$object = $objects->find(Common::getRequestString('id'));
		
		# Check rate value
		if ( (!($value = Common::getRequestInt('rate'))) ||
			 (($value < 1) || ($value > $table->gdoVoteMax())) )
		{
		    return $this->error('err_rate_param_between', [1, $table->gdoVoteMax()]);
		}
		
		$count = $table->countWhere(sprintf("vote_object=%s AND vote_ip='%s' AND vote_user!=%s", $object->getID(), GDT_IP::current(), $user->getID()));
		
		if ($count === 0)
		{
			# Vote
			$vote = $class::blank(array(
				'vote_user' => $user->getID(),
				'vote_object' => $object->getID(),
				'vote_ip' => GDT_IP::current(),
				'vote_value' => $value,
			));
			$vote instanceof GDO_VoteTable;
			$vote->replace();
			
			# Update cache
			$object->setVar('own_vote', $value);
			$object->updateVotes();
			$countColumn = $object->getVoteCountColumn();
			$rateColumn = $object->getVoteRatingColumn();
			
			if (Application::instance()->isAjax())
			{
    			return GDT_Response::make(array(
//     				'object' => $object->toJSON(),
    				'message' => t('msg_voted'),
    			    'countClass' => $countColumn->name. '-vote-count-'.$object->getID(),
    			    'ratingClass' => $rateColumn->name. '-vote-rating-'.$object->getID(),
    			    'count' => $countColumn->renderCell(),
    			    'rating' => $rateColumn->renderCell(),
    			));
			}
			return Website::redirect('/');
		}
		return $this->error('err_vote_ip');
	}
	
}
