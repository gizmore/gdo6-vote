<?php
namespace GDO\Vote;

use GDO\Template\GDO_Template;
use GDO\Type\GDO_Int;

class GDO_VoteCount extends GDO_Int
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
		return GDO_Template::php('Vote', 'cell/vote_count.php', ['field'=>$this]);
	}
	
}
