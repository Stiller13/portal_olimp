<?php

namespace Application\Command;


use System\Session\Session;
use System\Auth\Registration;


class RegistrationResult extends \System\Core\Command{

	public function exec() {
		$reg = new Registration();

		$result = $reg->register($this->req["login"], $this->req["pass1"], $this->req["pass2"]);

		if ($result === "Ok") {
			return $this->render(array("message" => "Регистрация прошла успешно!", "type_message" => "alert-success"), "MainPageShow");
		}
		return $this->render(array("message" => $result, "type_message" => "alert-danger"), "Registration");
	}
}
