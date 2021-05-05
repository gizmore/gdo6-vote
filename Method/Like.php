<?php
namespace GDO\Vote\Method;

use GDO\Core\Method;
use GDO\Core\GDO;
use GDO\Core\Website;
use GDO\Net\GDT_IP;
use GDO\Core\GDT_Response;
use GDO\User\GDO_User;
use GDO\Util\Common;
use GDO\Vote\GDO_LikeTable;
use GDO\Vote\GDT_LikeButton;
use GDO\Date\Time;
use GDO\DB\GDT_String;
use GDO\Vote\Module_Vote;
use GDO\DB\GDT_CreatedBy;

/**
 * The method to like an item.
 * @author gizmore
 */
final class Like extends Method
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
		
		# Get LikeTable, e.g. GDO_CommentLike
		$class = $this->gdoParameterVar('gdo');
		if (!class_exists($class))
		{
			return $this->error('err_vote_gdo');
		}
		if (!is_subclass_of($class, 'GDO\\Vote\\GDO_LikeTable'))
		{
			return $this->error('err_vote_table');
		}
		$table = GDO::tableFor($class);
		$table instanceof GDO_LikeTable;
		
		if ( (!$user->isMember()) && (!$table->gdoLikeForGuests()) )
		{
			return $this->error('err_members_only');
		}
		
		# Get GDO table, e.g. Link
		$objects = $table->gdoLikeObjectTable();
		
		# Get GDO row, e.g. Link
		$object = $objects->find(Common::getRequestString('id'));
		
		if (!$object->gdoCanLike($user))
		{
		    return $this->error('err_cannot_like');
		}
		
		# Check IP count
		$count = $table->countWhere(sprintf("like_object=%s AND like_ip='%s'", $object->getID(), GDT_IP::current()));
		if ($count >= $table->gdoMaxLikeCount())
		{
			return $this->error('err_vote_ip');
		}
		
		# Check user count
		$count = $table->countWhere(sprintf("like_object=%s AND like_user='%s'", $object->getID(), $user->getID()));
		if ($count >= $table->gdoMaxLikeCount())
		{
			return $this->error('err_vote_count', [$table->gdoMaxLikeCount()]);
		}
		
		# Check last vote date against cooldown
		$lastVoteDate = $table->select('like_created')->
			where(sprintf("like_object=%s", $object->getID()))->
			where(sprintf("like_user=%s or like_ip='%s'", $user->getID(), GDT_IP::current()))->
			orderDESC('like_created')->
			first()->exec()->fetchValue();
		if ( $lastVoteDate && (Time::getAgo($lastVoteDate) < $table->gdoLikeCooldown()) )
		{
			return $this->error('err_vote_frequency', [Time::humanDuration($table->gdoLikeCooldown())]);
		}
		
		# Vote
		$like = $class::blank(array(
			'like_user' => $user->getID(),
			'like_object' => $object->getID(),
			'like_ip' => GDT_IP::current(),
		));
		$like instanceof GDO_LikeTable;
		$like->insert();
		
		# Update cache
		$object->updateLikes();

		# Update user likes
		if ($otherUser = $object->gdoColumnOf(GDT_CreatedBy::class))
		{
		    $otherUser = $otherUser->getValue();
		    Module_Vote::instance()->increaseUserSetting($otherUser, 'likes');
		}
		
		Website::redirectBack();
		
		return GDT_Response::makeWith(
			GDT_LikeButton::make('likes')->gdo($object)
		);
		
	}
}
