<?php
namespace GDO\Vote;

use GDO\Core\GDT_Template;
use GDO\DB\GDT_UInt;

class GDT_VoteCount extends GDT_UInt
{
	public $writable = false;
	public $editable = false;
	
	public function defaultLabel() { return $this->label('votes'); }

	public function __construct()
	{
		$this->initial = "0";
	}
	
	public function getVoteObject()
	{
		return $this->gdo;
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/vote_count.php', ['field'=>$this]);
	}
	
}
