<?php
namespace GDO\Vote;

use GDO\Template\GDT_Template;
use GDO\Type\GDT_Decimal;

final class GDT_VoteRating extends GDT_Decimal
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
		return GDT_Template::php('Vote', 'cell/vote_rating.php', ['field'=>$this]);
	}
}
