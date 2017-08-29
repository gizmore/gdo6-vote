<?php
namespace GDO\Vote;

use GDO\User\GDO_User;

trait WithVotes
{
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
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDT_VoteCount)
			{
				return $gdoType->getValue();
			}
		}
		return $this->queryVoteCount();
	}
	
	public function queryVoteCount()
	{
		$votes = $this->gdoVoteTable();
		$votes instanceof GDO_VoteTable;
		return $votes->countWhere('vote_object='.$this->getID());
	}
	
	public function getVoteRating()
	{
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDT_VoteRating)
			{
				return $gdoType->getValue();
			}
		}
		return $this->queryVoteRating();
	}
	
	public function queryVoteRating()
	{
		$votes = $this->gdoVoteTable();
		$votes instanceof GDO_VoteTable;
		return (int) $votes->select('AVG(vote_value)')->where('vote_object='.$this->getID())->exec()->fetchValue();
	}
	
}
