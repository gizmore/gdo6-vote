<?php
namespace GDO\Vote;

use GDO\Core\GDT_Template;

class GDT_LikeCount extends GDT_VoteCount
{
	public $writable = false;
	public $editable = false;
	
	public function defaultLabel() { return $this->label('likes'); }

	public function getLikeObject()
	{
		return $this->gdo;
	}
	
	/**
	 * @return GDO_LikeTable
	 */
	public function getLikeTable()
	{
		return $this->gdo->gdoLikeTable();
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/like_count.php', ['field'=>$this]);
	}
	
}
