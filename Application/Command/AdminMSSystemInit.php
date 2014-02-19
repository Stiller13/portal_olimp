<?php

namespace Application\Command;

class AdminMSSystemInit extends \System\Core\Command{

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$manager = \System\Msg\FactoryMGManager::getManager("system");
		$manager->Init();

		return $this->redirect("/admin_cabinet/message");
	}
}
