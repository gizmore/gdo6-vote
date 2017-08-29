<?php
namespace GDO\Vote;

use GDO\DB\GDO;
use GDO\DB\GDT_Object;
use GDO\Net\GDT_IP;
use GDO\Type\GDT_Int;
use GDO\User\GDT_User;
use GDO\User\GDO_User;

class GDO_VoteTable extends GDO
{
	/**
	 * @return GDO
	 */
	public function gdoVoteObjectTable() {}
	public function gdoVoteMax() { return 5; }
	public function gdoCached() { return false; }
	public function gdoAbstract() { return $this->gdoVoteObjectTable() === null; }
	public function gdoColumns()
	{
		return array(
			GDT_User::make('vote_user')->primary(),
			GDT_Object::make('vote_object')->table($this->gdoVoteObjectTable())->primary(),
			GDT_IP::make('vote_ip')->notNull(),
			GDT_Int::make('vote_value')->notNull()->unsigned()->bytes(1),
		);
	}
	/**
	 * @return User
	 */
	public function getUser() { return $this->getValue('vote_user'); }
	public function getUserID() { return $this->getVar('vote_user'); }
	/**
	 * @return GDO
	 */
	public function getObject() { return $this->getValue('vote_object'); }
	public function getObjectID() { return $this->getVar('vote_object'); }
	public function getIP() { return $this->getVar('vote_ip'); }
	public function getScore() { return $this->getVar('vote_value'); }

	################
	### Factory ###
	###############
	/**
	 * @param GDO_User $user
	 * @param GDO $object
	 * @return self
	 */
	public function getVote(GDO_User $user, GDO $object)
	{
	    return self::getById($user->getID(), $object->getID());
	}
	
}