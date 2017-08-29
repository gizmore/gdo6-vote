<?php
namespace GDO\Vote;

use GDO\Template\GDT_Template;
use GDO\Type\GDT_Int;

class GDT_VoteCount extends GDT_Int
{
	public $writable = false;
	public $editable = false;
	
	public function defaultLabel() { return $this->label('votes'); }

	public function __construct()
	{
		$this->unsigned = true;
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
