<?php

namespace Application\Command;

class MyProfileShow extends \System\Core\Command{

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		$list_uss = array(
			array("id" => 0, "name" => "Не выбрано"),
			array("id" => 1, "name" => "Школьник"),
			array("id" => 2, "name" => "Учитель"),
			array("id" => 3, "name" => "Студент"),
			array("id" => 4, "name" => "Преподаватель")
		);

		return $this->render(array("user" => $user, "list_uss" => $list_uss));
	}
}
