<?php
namespace GDO\Vote;

use GDO\Core\GDT_Template;
use GDO\Core\GDT;

final class GDT_VoteSelection extends GDT
{
	public function defaultLabel()
	{
		return $this->label('vote');
	}
	
	/**
	 * @return GDO_VoteTable
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
	
	public function ownVote()
	{
	    return $this->gdo->getVar('own_vote');
	}
	
	public function hrefVoteScore($score)
	{
	    return $this->hrefVote() . "&rate=$score";
	}
	
	public function hrefVote()
	{
	    return href('Vote', 'Up', '&gdo='.urlencode($this->voteTable()->gdoClassName()).'&id='.$this->gdo->getID());
	}

	public function renderJSON()
	{
		return array(
			'rating' => $this->voteRating(),
			'own_vote' => $this->ownVote(),
			'count' => $this->voteCount(),
			'voteurl' => $this->hrefVote(),
		);
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/vote_selection.php', ['field'=>$this]);
	}
}
