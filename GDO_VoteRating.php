<?php
namespace GDO\Vote;

use GDO\Template\GDO_Template;
use GDO\Type\GDO_Decimal;

final class GDO_VoteRating extends GDO_Decimal
{
	public $writable = false;
	public $editable = false;
	
	public function defaultLabel()
	{
		$this->initial('0.00');
		return $this->label('rating');
	}
	
	public function __construct()
	{
		$this->digits(3, 1);
	}

	public function getVoteObject()
	{
		return $this->gdo;
	}
	
	public function renderCell()
	{
		return GDO_Template::php('Vote', 'cell/vote_rating.php', ['field'=>$this]);
	}
}
