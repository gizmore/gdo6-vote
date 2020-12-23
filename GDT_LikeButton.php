<?php
namespace GDO\Vote;

use GDO\Core\GDT_Template;
use GDO\UI\GDT_Button;
use GDO\Core\GDO;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;

class GDT_LikeButton extends GDT_Link
{
	public function defaultLabel() { return $this->label('likes'); }
	
	protected function __construct()
	{
		$this->icon('like');
	}
	
	public function gdo(GDO $gdo=null)
	{
		parent::gdo($gdo);
		$likeObject = $this->getLikeObject();
		$likeTable = $this->getLikeTable();
		$this->href = href('Vote', 'Like', "&gdo={$likeTable->gdoClassName()}&id={$likeObject->getID()}");
		$this->editable(!$gdo->hasLiked(GDO_User::current()));
		return $this;
	}

	public function getLikeObject()
	{
		return $this->gdo;
	}
	
	/**
	 * @return GDO_LikeTable
	 */
	public function getLikeTable()
	{
		return $this->getLikeObject()->gdoLikeTable();
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/like_button.php', ['field'=>$this]);
	}
	
	public function configJSON()
	{
		return [$this->name => [
			'count' => $this->getLikeObject()->getLikeCount(),
		]];
	}
}
