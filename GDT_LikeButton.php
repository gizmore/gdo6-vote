<?php
namespace GDO\Vote;

use GDO\Template\GDT_Template;
use GDO\UI\GDT_Button;

class GDT_LikeButton extends GDT_Button
{
	public function defaultLabel() { return $this->label('votes'); }

	public function getLikeObject()
	{
		return $this->gdo;
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/like_button.php', ['field'=>$this]);
	}
}
