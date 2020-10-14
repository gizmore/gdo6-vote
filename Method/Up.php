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
use GDO\DB\GDT_String;
use GDO\Date\Time;
use GDO\Core\GDT_JSON;
use GDO\Vote\WithVotes;
/**
 * Vote on an item.
 * Check for IP duplicates.
 * @author gizmore
 */
final class Up extends Method
{
	public function gdoParameters()
	{
		return array(
			GDT_String::make('gdo')->notNull(),
		);
	}
	
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
		/**
		 * @var WithVotes $object
		 */
		$object = $objects->find(Common::getRequestString('id'));
		
		if (!$object->gdoVoteAllowed($user))
		{
		    return $this->error('err_vote_not_allowed')->add(Website::redirectBack(5));
		}
		
		# Check rate value
		if ( (!($value = Common::getRequestInt('rate'))) ||
			 (($value < 1) || ($value > $table->gdoVoteMax())) )
		{
			return $this->error('err_rate_param_between', [1, $table->gdoVoteMax()]);
		}
		
		if ($user->isGuest() && (!$table->gdoVoteGuests()))
		{
			return $this->error('err_vote_guest');
		}
		
		$cooldown = Time::getDate(Application::$TIME - $table->gdoVoteCooldown());
		$where = sprintf("vote_object=%s AND vote_ip='%s' AND vote_user!=%s AND vote_created>='%s'",
			$object->getID(), GDT_IP::current(), $user->getID(), $cooldown);
		$count = $table->countWhere($where);
		
		if ($count === 0)
		{
			# Vote
			$vote = $class::blank(array(
				'vote_user' => $user->persistent()->getID(),
				'vote_object' => $object->getID(),
				'vote_ip' => GDT_IP::current(),
				'vote_value' => $value,
			));
			$vote instanceof GDO_VoteTable;
			$vote->replace();
			
			# Update cache
			$object->setVar('own_vote', $value);
			$object->updateVotes();
			$object instanceof WithVotes;
// 			$countColumn = $object->getVoteCountColumn();
			$rateColumn = $object->getVoteRatingColumn();
			
			if (Application::instance()->isAjax())
			{
				$enough = $object->hasEnoughVotes();
				$count = $enough ? $object->displayVoteCount() : -1;
				$rating = $enough ? $object->displayVoteRating() : -1;
				return GDT_Response::makeWith(
					GDT_JSON::make('json')->value(array(
						'message' => t('msg_voted'),
					    'outcome' => $rateColumn->render() . $object->getVoteCountColumn()->render(),
						'outcomeId' => $object->getVoteOutcomeId(),
						'enough' => $enough,
						'count' => $count,
						'rating' => $rating,
					))
				);
			}
			return Website::redirectBack();
		}
		return $this->error('err_vote_ip');
	}
	
}
