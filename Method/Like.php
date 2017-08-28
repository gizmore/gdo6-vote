<?php
namespace GDO\Vote\Method;

use GDO\Core\Method;
use GDO\DB\GDO;
use GDO\Net\GDO_IP;
use GDO\Template\Response;
use GDO\User\User;
use GDO\Util\Common;
use GDO\Vote\LikeTable;

final class Like extends Method
{
	public function execute()
	{
		$user = User::current();
		
		# Get LikeTable, e.g. GWF_ProfileLike
		$class = Common::getRequestString('gdo');
		if (!class_exists($class, false))
		{
			return $this->error('err_vote_gdo');
		}
		if (!is_subclass_of($class, 'GDO\\Vote\\LikeTable'))
		{
			return $this->error('err_vote_table');
		}
		$table = GDO::tableFor($class);
		$table instanceof LikeTable;
		
		# Get GDO table, e.g. Link
		$objects = $table->gdoLikeObjectTable();
		$objects instanceof GDO;
		
		# Get GDO row, e.g. Link
		$object = $objects->find(Common::getRequestString('id'));
		
		$count = $table->countWhere(sprintf("like_object=%s AND like_ip='%s'", $object->getID(), GDO_IP::current()));
		
		if ($count === 0)
		{
			# Vote
			$like = $class::blank(array(
				'like_user' => $user->getID(),
				'like_object' => $object->getID(),
				'like_ip' => GDO_IP::current(),
			));
			$like instanceof LikeTable;
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
