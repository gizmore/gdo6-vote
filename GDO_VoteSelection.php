<?php
namespace GDO\Vote;

use GDO\Template\GDO_Template;
use GDO\Type\GDO_Base;

final class GDO_VoteSelection extends GDO_Base
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
	
	public function initJSON()
	{
		return json_encode(array(
			'rating' => $this->voteRating(),
			'own_vote' => $this->gdo->getVar('own_vote'),
			'count' => $this->voteCount(),
			'voteurl' => href('Vote', 'Up', '&gdo='.$this->voteTable()->gdoClassName().'&id='.$this->gdo->getID()),
		));
	}
	
	public function renderCell()
	{
		return GDO_Template::php('Vote', 'cell/vote_selection.php', ['field'=>$this]);
	}
}
