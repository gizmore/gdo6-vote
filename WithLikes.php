<?php
namespace GDO\Vote;

use GDO\User\GDO_User;

trait WithLikes
{
	public function hasLiked(GDO_User $user)
	{
		return !!$this->getLike($user);
	}
	
	public function getLike(GDO_User $user)
	{
		$likes = $this->gdoLikeTable();
		$likes instanceof GDO_LikeTable;
		return $likes->getLike($user, $this);
	}
	
	public function updateLikes()
	{
		$vars = [];
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDT_LikeCount)
			{
				$vars[$gdoType->name] = $this->queryLikeCount();
			}
		}
		return $this->saveVars($vars, false);
	}
	
	public function getLikeCount()
	{
		foreach ($this->gdoColumnsCache() as $gdoType)
		{
			if ($gdoType instanceof GDT_LikeCount)
			{
				return $this->getVar($gdoType->name);
			}
		}
		return $this->queryLikeCount();
	}
	
	public function queryLikeCount()
	{
		$likes = $this->gdoLikeTable();
		$likes instanceof GDO_LikeTable;
		return $likes->countWhere('like_object='.$this->getID());
	}
	
}
