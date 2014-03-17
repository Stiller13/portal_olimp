<?php

namespace Application\Command;

class AdminModerAdd extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");


		$role_user = new \Application\Model\UserRole();

		$role_user->setUser_id($this->data["user_id"]);
		$role_user->setRole("MODERATOR");

		$factory = \System\Orm\PersistenceFactory::getFactory("UserRole");
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$finder->insert($role_user);

		return $this->redirect("/admin_cabinet/users/moderators");
	}
}
