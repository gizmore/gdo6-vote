<?php
namespace GDO\Vote;

use GDO\Template\GDT_Template;
use GDO\Type\GDT_Base;

final class GDT_VoteSelection extends GDT_Base
{
	public function defaultLabel()
	{
		return $this->label('vote');
	}
	
	/**
	 * @return VoteTable
	 */
	public function voteTable()
	{
		return $this->gdo->gdoVoteTable();
	}
	
	public function voteCount()
	{
		return $this->gdo->getVoteCount();
	}
	
	public function voteRating()
	{
		return $this->gdo->getVoteRating();
	}
	
	public function toJSON()
	{
		return array(
			'rating' => $this->voteRating(),
			'own_vote' => $this->gdo->getVar('own_vote'),
			'count' => $this->voteCount(),
			'voteurl' => href('Vote', 'Up', '&gdo='.urlencode($this->voteTable()->gdoClassName()).'&id='.$this->gdo->getID()),
		);
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/vote_selection.php', ['field'=>$this]);
	}
}
