<?php
namespace GDO\Vote;

use GDO\Core\GDT_Template;
use GDO\Core\GDO;
use GDO\User\GDO_User;
use GDO\UI\GDT_IconButton;

class GDT_LikeButton extends GDT_IconButton
{
	public function defaultLabel() { return $this->label('likes'); }
	
	protected function __construct()
	{
	    parent::__construct();
		$this->icon('like');
	}
	
	public function gdo(GDO $gdo=null)
	{
		parent::gdo($gdo);
		$likeObject = $this->getLikeObject();
		$likeTable = $this->getLikeTable();
		$hasLiked = $likeObject->hasLiked(GDO_User::current());
		$method = $hasLiked ? 'UnLike' : 'Like';
		$this->href = href('Vote', $method, "&gdo={$likeTable->gdoClassName()}&id={$likeObject->getID()}");
// 		$this->editable(!$gdo->hasLiked(GDO_User::current()));
		return $this;
	}


	/**
	 * @return WithLikes
	 */
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
	
	public $dislike = false;
	public function dislike($dislike=true)
	{
	    $this->dislike = $dislike;
	    return $this;
	}
	
	public function configJSON()
	{
		return array_merge(parent::configJSON(), [
			'count' => $this->getLikeObject()->getLikeCount(),
		]);
	}
	
	public function renderJSON()
	{
	    return [
	        'html' => $this->renderCell(),
	        'count' => $this->getLikeObject()->getLikeCount(),
	    ];
	}
	
}
