<?php
namespace GDO\Vote;

use GDO\User\User;

trait WithLikes
{
	public function hasLiked(User $user)
	{
		return !!$this->getLike($user);
	}
	
	public function getLike(User $user)
	{
		$likes = $this->gdoLikeTable();
		$likes instanceof LikeTable;
		return $likes->getLike($user, $this);
	}
	
	public function updateLikes()
	{
		$vars = [];
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDO_LikeCount)
			{
				$vars[$gdoType->name] = $this->queryLikeCount()();
			}
		}
		return $this->saveVars($vars);
	}
	
	public function getLikeCount()
	{
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDO_LikeCount)
			{
				return $gdoType->getValue();
			}
		}
		return $this->queryLikeCount();
	}
	
	public function queryLikeCount()
	{
		$likes = $this->gdoLikeTable();
		$likes instanceof LikeTable;
		return $likes->countWhere('like_object='.$this->getID());
	}
	
}
