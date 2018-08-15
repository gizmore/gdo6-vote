<?php
namespace GDO\Vote;

use GDO\User\GDO_User;

/**
 * To make a GDO votable do
 * 1. Create a table extend GDO_VoteTable
 * 2. Implement gdoVoteTable()
 * 
 * @author gizmore
 * @see GDO_VoteTable
 */
trait WithVotes
{
//	 public function gdoVoteTable()
//	 {
//	 }
	
	public function hasVoted(GDO_User $user)
	{
		return !!$this->getVote($user);
	}
	
	public function getVote(GDO_User $user)
	{
		$votes = $this->gdoVoteTable();
		$votes instanceof GDO_VoteTable;
		return $votes->getVote($user, $this);
	}
	
	public function updateVotes()
	{
		$vars = [];
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDT_VoteCount)
			{
				$vars[$gdoType->name] = $this->queryVoteCount();
			}
			elseif ($gdoType instanceof GDT_VoteRating)
			{
				$vars[$gdoType->name] = $this->queryVoteRating();
			}
		}
		return $this->saveVars($vars);
	}

	public function getVoteCount()
	{
		if ($column = $this->getVoteCountColumn())
		{
			return $column->getValue();
		}
		return $this->queryVoteCount();
	}
	
	/**
	 * @return \GDO\Vote\GDT_VoteCount
	 */
	public function getVoteCountColumn()
	{
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDT_VoteCount)
			{
				return $gdoType->gdo($this);
			}
		}
	}
	
	public function queryVoteCount()
	{
		$votes = $this->gdoVoteTable();
		$votes instanceof GDO_VoteTable;
		return $votes->countWhere('vote_object='.$this->getID());
	}
	
	public function getVoteRating()
	{
		if ($column = $this->getVoteRatingColumn())
		{
			return $column->getValue();
		}
		return $this->queryVoteRating();
	}
	
	/**
	 * @return \GDO\Vote\GDT_VoteRating
	 */
	public function getVoteRatingColumn()
	{
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDT_VoteRating)
			{
				return $gdoType->gdo($this);
			}
		}
	}
	
	public function queryVoteRating()
	{
		$votes = $this->gdoVoteTable();
		$votes instanceof GDO_VoteTable;
		return (int) $votes->select('AVG(vote_value)')->where('vote_object='.$this->getID())->exec()->fetchValue();
	}
	
}
