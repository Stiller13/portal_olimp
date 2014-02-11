<?php

namespace Application\Command;

class RegistrationResult extends \System\Core\Command{

	protected function exec() {
		$reg = new \System\Auth\Registration();

		$result = $reg->register($this->req["login"], $this->req["pass1"], $this->req["pass2"]);

		if ($result === "Ok") {
			return $this->render(array("message" => "Регистрация прошла успешно!", "type_message" => "alert-success"), "MainPageShow");
		}
		return $this->render(array("message" => $result, "type_message" => "alert-danger"), "Registration");
	}
}
