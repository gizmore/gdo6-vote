<?php
namespace GDO\Vote;

use GDO\DB\GDO;
use GDO\DB\GDO_Object;
use GDO\Net\GDO_IP;
use GDO\User\GDO_User;

class LikeTable extends GDO
{
	/**
	 * @return GDO
	 */
	public function gdoLikeObjectTable() {}
	
	public function gdoCached() { return false; }
	public function gdoAbstract() { return $this->gdoLikeObjectTable() === null; }
	public function gdoColumns()
	{
		return array(
			GDO_User::make('like_user')->primary(),
			GDO_Object::make('like_object')->table($this->gdoLikeObjectTable())->primary(),
			GDO_IP::make('like_ip')->notNull(),
		);
	}
	
}
