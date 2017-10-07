<?php
namespace GDO\Vote\Method;

use GDO\Core\Method;
use GDO\Core\GDO;
use GDO\Net\GDT_IP;
use GDO\Template\Response;
use GDO\User\GDO_User;
use GDO\Util\Common;
use GDO\Vote\GDO_LikeTable;

final class Like extends Method
{
	public function execute()
	{
		$user = GDO_User::current();
		
		# Get LikeTable, e.g. GDO_CommentLike
		$class = Common::getRequestString('gdo');
		if (!class_exists($class, false))
		{
			return $this->error('err_vote_gdo');
		}
		if (!is_subclass_of($class, 'GDO\\Vote\\GDO_LikeTable'))
		{
			return $this->error('err_vote_table');
		}
		$table = GDO::tableFor($class);
		$table instanceof GDO_LikeTable;
		
		# Get GDO table, e.g. Link
		$objects = $table->gdoLikeObjectTable();
		$objects instanceof GDO;
		
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

			return Response::make(array(
				'object' => $object->toJSON(),
				'message' => t('msg_liked'), 
			));
		}
		
		return $this->error('err_vote_ip');
	}
}
