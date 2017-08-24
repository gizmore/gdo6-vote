<?php
namespace GDO\Vote;

use GDO\Template\GDO_Template;
use GDO\UI\GDO_Button;

class GDO_LikeButton extends GDO_Button
{
	public function defaultLabel() { return $this->label('votes'); }

	public function getLikeObject()
	{
		return $this->gdo;
	}
	
	public function renderCell()
	{
		return GDO_Template::php('Vote', 'cell/like_button.php', ['field'=>$this]);
	}
}
