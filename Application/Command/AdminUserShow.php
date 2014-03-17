<?php

namespace Application\Command;

class AdminUserShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory_user = \System\Orm\PersistenceFactory::getFactory("User");
		$user_finder = new \System\Orm\DomainObjectAssembler($factory_user);
		$user_io = $factory_user->getIndentityObject();

		$user_io->field('user_id')->eq($this->data["user_id"]);

		$one_user = $user_finder->findOne($user_io, "user");

		$list_uss = \System\Helper\Helper::getAll("user_status");

		return $this->render(array("user" => $user, "one_user" => $one_user, "list_uss" => $list_uss));
	}
}
