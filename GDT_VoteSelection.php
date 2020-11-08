<?php
namespace GDO\Vote;

use GDO\Core\GDT_Template;
use GDO\Core\GDT;
use GDO\UI\WithLabel;
use GDO\User\GDO_User;

final class GDT_VoteSelection extends GDT
{
	use WithLabel;

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

	public function configJSON()
	{
		return array(
			'rating' => $this->voteRating(),
			'own_vote' => $this->ownVote(),
			'count' => $this->voteCount(),
			'voteurl' => $this->hrefVote(),
		);
	}
	
	public function canVote()
	{
	    $user = GDO_User::current();
	    if ($user->isGuest() && (!$this->gdo->gdoVoteTable()->gdoVoteGuests()) )
	    {
	        return false;
	    }
	    return $this->gdo->gdoVoteAllowed($user);
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Vote', 'cell/vote_selection.php', ['field'=>$this]);
	}
}
