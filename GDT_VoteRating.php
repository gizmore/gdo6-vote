<?php
namespace GDO\Vote;

use GDO\Core\GDO;
use GDO\Core\GDT_Template;
use GDO\DB\GDT_Decimal;

final class GDT_VoteRating extends GDT_Decimal
{
    public $orderDefaultAsc = false;
    
    public function defaultLabel() { return $this->label('rating'); }
	
	/**
	 * @return GDO|WithVotes
	 */
	public function getVoteObject() { return $this->gdo; }
	
	public function __construct()
	{
	    $this->writable = false;
	    $this->editable = false;
		$this->digits(3, 1);
		$this->initial('0');
	}

	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/vote_rating.php', ['field'=>$this]);
	}
	
}
