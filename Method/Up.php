<?php
namespace GDO\Vote\Method;

use GDO\Core\Method;
use GDO\DB\GDO;
use GDO\Net\GDT_IP;
use GDO\Template\Response;
use GDO\User\User;
use GDO\Util\Common;
use GDO\Vote\VoteTable;
/**
 * Vote on an item.
 * Check for IP duplicates.
 * @author gizmore
 */
final class Up extends Method
{
	public function execute()
	{
		$user = User::current();
		
		# Get VoteTable, e.g. LinkVote
		$class= Common::getRequestString('gdo');
		if (!@class_exists($class))
		{
			return $this->error('err_vote_gdo');
		}
		if (!is_subclass_of($class, 'GDO\Vote\VoteTable'))
		{
			return $this->error('err_vote_table');
		}
		$table = GDO::tableFor($class);
		$table instanceof VoteTable;
		
		# Get GDO table, e.g. Link
		$objects = $table->gdoVoteObjectTable();
		$objects instanceof GDO;
		
		# Get GDO row, e.g. Link
		$object = $objects->find(Common::getRequestString('id'));
		
		# Check rate value
		if ( (!($value = Common::getRequestInt('rate'))) ||
			 (($value < 1) || ($value > $table->gdoVoteMax())) )
		{
			return $this->error('err_rate_param_between', [1, $object->gdoVoteMax()]);
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
			$vote instanceof VoteTable;
			$vote->replace();
			
			# Update cache
			$object->setVar('own_vote', $value);
			$object->updateVotes();

			return Response::make(array(
				'object' => $object->toJSON(),
				'message' => t('msg_voted'), 
			));
		}
		
		return $this->error('err_vote_ip');
	}
	
}
