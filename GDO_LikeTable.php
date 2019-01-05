<?php
namespace GDO\Vote;

use GDO\Core\GDO;
use GDO\DB\GDT_Object;
use GDO\Net\GDT_IP;
use GDO\User\GDO_User;
use GDO\User\GDT_User;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_AutoInc;

class GDO_LikeTable extends GDO
{
	/**
	 * @return GDO
	 */
	public function gdoLikeObjectTable() {}
	public function gdoLikeForGuests() { return true; }
	public function gdoMaxLikeCount() { return 1; }
	public function gdoLikeCooldown() { return 60*60*24; }
	
	public function gdoCached() { return false; }
	public function gdoAbstract() { return $this->gdoLikeObjectTable() === null; }
	public function gdoColumns()
	{
		return array(
			GDT_AutoInc::make('like_id'),
			GDT_User::make('like_user'),
			GDT_Object::make('like_object')->table($this->gdoLikeObjectTable()),
			GDT_IP::make('like_ip')->notNull(),
			GDT_CreatedAt::make('like_created'),
		);
	}
	
	public function getLike(GDO_User $user, GDO $likeObject)
	{
		return self::table()->select()->where("like_user={$user->getID()} AND like_object={$likeObject->getID()}")->first()->exec()->fetchObject();
	}
	
}
