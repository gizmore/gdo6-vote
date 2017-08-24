<?php
namespace GDO\Vote;

use GDO\Template\GDO_Template;

class GDO_LikeCount extends GDO_VoteCount
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
		return GDO_Template::php('Vote', 'cell/like_count.php', ['field'=>$this]);
	}
	
}
