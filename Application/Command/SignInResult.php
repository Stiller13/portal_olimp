<?php

namespace Application\Command;

use System\Auth\Login;
use System\Auth\DefaultGate;

class SignInResult extends \System\Core\Command{

	protected function exec() {
		//$gate = new DefaultGate(); 
		$auth = Login::instance();
		$result = $auth->SignIn($this->req["login"], $this->req["pass"]);

		$session = new \System\Session\Session();
		$user = $session->get("user");

		if ($result === "Ok") {
			return $this->render(array("user" => $user, "message" => "Вход в систему осуществлен", "type_message" => "alert-success"), "MainPageShow");
		}

		return $this->render(array("message" => $result, "type_message" => "alert-danger"), "MainPageShow");
	}
}
