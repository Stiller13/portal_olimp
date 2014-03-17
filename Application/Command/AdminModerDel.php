<?php

namespace Application\Command;

class AdminModerDel extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory = \System\Orm\PersistenceFactory::getFactory("UserRole");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("role_user")->eq($this->data["user_id"]);

		$finder->delete($idobj, "role");

		return $this->redirect("/admin_cabinet/users/moderators");
	}
}
