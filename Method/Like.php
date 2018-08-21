<?php
namespace GDO\Vote\Method;

use GDO\Core\Method;
use GDO\Core\GDO;
use GDO\Net\GDT_IP;
use GDO\Core\GDT_Response;
use GDO\User\GDO_User;
use GDO\Util\Common;
use GDO\Vote\GDO_LikeTable;
use GDO\Vote\GDT_LikeButton;

/**
 * The method to like an item.
 * @author gizmore
 */
final class Like extends Method
{
	public function execute()
	{
		$user = GDO_User::current();
		
		# Get LikeTable, e.g. GDO_CommentLike
		$class = Common::getRequestString('gdo');
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
		
		$count = $table->countWhere(sprintf("like_object=%s AND like_ip='%s'", $object->getID(), GDT_IP::current()));
		
		if ($count === 0)
		{
			# Vote
			$like = $class::blank(array(
				'like_user' => $user->getID(),
				'like_object' => $object->getID(),
				'like_ip' => GDT_IP::current(),
			));
			$like instanceof GDO_LikeTable;
			$like->replace();
			
			# Update cache
			$object->updateLikes();

			return GDT_Response::makeWith(
				GDT_LikeButton::make('likes')->gdo($object)
			);
		}
		
		return $this->error('err_vote_ip');
	}
}
