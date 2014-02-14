<?php

namespace Application\Command;

class MyProfileShow extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		return $this->render(array("user" => $user));
	}
}
