<?php

namespace Application\Command;

class MyProfileShow extends \System\Core\Command{

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		$list_uss = \System\Helper\Helper::getAll("user_status");

		return $this->render(array("user" => $user, "list_uss" => $list_uss));
	}
}
