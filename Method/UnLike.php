<?php
namespace GDO\Vote\Method;

use GDO\Core\Method;
use GDO\Core\GDO;
use GDO\Core\GDT_Response;
use GDO\User\GDO_User;
use GDO\Util\Common;
use GDO\Vote\GDO_LikeTable;
use GDO\Vote\GDT_LikeButton;
use GDO\Vote\Module_Vote;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_Object;
use GDO\DB\GDT_String;
use GDO\Core\Website;
use GDO\Core\Application;

/**
 * The method to like an item.
 * @author gizmore
 */
class UnLike extends Method
{
    public function isCLI() { return false; }
    public function showInSitemap() { return false; }
    
    public function gdoParameters()
	{
	    return [
	        GDT_String::make('gdo')->notNull(),
	        GDT_Object::make('id')->table($this->getLikeTable())->notNull(),
	    ];
	}
	
	/**
	 * @return GDO_LikeTable
	 */
	public function getLikeTable()
	{
	    return call_user_func([$this->getLikeTableClass(), 'table']);
	}
	
	public function getLikeTableClass()
	{
	    return $this->gdoParameterVar('gdo');
	}
	
	public function execute()
	{
		$user = GDO_User::current();
		
		# Get LikeTable, e.g. GDO_CommentLike
		$class = $this->getLikeTableClass();
		if (!class_exists($class))
		{
			return $this->error('err_vote_gdo');
		}
		if (!is_subclass_of($class, 'GDO\\Vote\\GDO_LikeTable'))
		{
			return $this->error('err_vote_table');
		}
		$table = GDO::tableFor($class);
		$table instanceof GDO_LikeTable;
		
		if ( (!$user->isMember()) && (!$table->gdoLikeForGuests()) )
		{
			return $this->error('err_members_only');
		}
		
		# Get GDO table, e.g. Link
		$objects = $table->gdoLikeObjectTable();
		
		# Get GDO row, e.g. Link
		$object = $objects->find(Common::getRequestString('id'));
		
		# Check user count
		$count = $table->countWhere(sprintf("like_object=%s AND like_user='%s'", $object->getID(), $user->getID()));
		if ($count < 1)
		{
			return $this->error('err_not_liked');
		}

		# Delete like
		$deleted = $table->deleteWhere("like_object={$object->getID()} AND like_user={$user->getID()}");

		# Update cache
		$object->updateLikes();
		
		if ($deleted)
		{
    		# Update user likes
    		if ($otherUser = $object->gdoColumnOf(GDT_CreatedBy::class))
    		{
    		    $otherUser = $otherUser->getValue();
    		    Module_Vote::instance()->increaseUserSetting($otherUser, 'likes', -1);
    		}
		}
		
		Website::redirectBack();
		
		if (Application::instance()->isCLI())
		{
		    return $this->message('msg_disliked');
		}
		
		return GDT_Response::makeWith(
			GDT_LikeButton::make('likes')->gdo($object)
		);
		
	}
}
