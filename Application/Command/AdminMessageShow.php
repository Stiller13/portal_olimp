<?php

namespace Application\Command;

class AdminMessageShow extends \System\Core\Command{

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		return $this->render(array("user" => $user));
	}
}
