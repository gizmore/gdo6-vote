<?php
namespace GDO\Vote;

use GDO\Core\GDO;
use GDO\DB\GDT_Object;
use GDO\Net\GDT_IP;
use GDO\User\GDT_User;

class GDO_LikeTable extends GDO
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
			GDT_User::make('like_user')->primary(),
			GDT_Object::make('like_object')->table($this->gdoLikeObjectTable())->primary(),
			GDT_IP::make('like_ip')->notNull(),
		);
	}
	
}
