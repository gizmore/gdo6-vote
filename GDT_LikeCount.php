<?php
namespace GDO\Vote;

use GDO\Template\GDT_Template;

class GDT_LikeCount extends GDT_VoteCount
{
	public $writable = false;
	public $editable = false;
	
	public function defaultLabel() { return $this->label('likes'); }

	public function getLikeObject()
	{
		return $this->gdo;
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/like_count.php', ['field'=>$this]);
	}
	
}
