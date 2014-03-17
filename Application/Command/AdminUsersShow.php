<?php

namespace Application\Command;

class AdminUsersShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory_user = \System\Orm\PersistenceFactory::getFactory("User");
		$user_finder = new \System\Orm\DomainObjectAssembler($factory_user);
		$user_io = $factory_user->getIndentityObject();

		switch ($this->data["type_users"]) {
			case 'moderators':
				$user_io->addJoin("INNER", array("user", "role"), array("user_id", "role_user"));
				$user_io->field("role_role")->eq(\System\Helper\Helper::getId("role", "MODERATOR"));

				$view = "AdminModeratorsShow";
				break;
			default:
				$view = "AdminUsersShow";
				break;
		}

		$mode_sort = $this->data["mode_sort"];
		switch ($mode_sort) {
			case "id_up":
				$user_io->addOrder(array("user_id"=>"ASC"));
				break;
			case "id_down":
				$user_io->addOrder(array("user_id"=>"DESC"));
				break;
			case "name_up":
				$user_io->addOrder(array("user_name"=>"ASC"));
				break;
			case "name_down":
				$user_io->addOrder(array("user_name"=>"DESC"));
				break;
			case "surname_up":
				$user_io->addOrder(array("user_surname"=>"ASC"));
				break;
			case "surname_down":
				$user_io->addOrder(array("user_surname"=>"DESC"));
				break;
			case "gender_up":
				$user_io->addOrder(array("user_gender"=>"ASC"));
				break;
			case "gender_down":
				$user_io->addOrder(array("user_gender"=>"DESC"));
				break;
			default:
				$user_io->addOrder(array("user_id"=>"ASC"));
				break;
		}

		$user_list = $user_finder->find($user_io, "user");

		return $this->render(array("user" => $user, "user_list" => $user_list, $mode_sort => 1), $view);
	}
}
