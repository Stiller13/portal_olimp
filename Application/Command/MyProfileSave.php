<?php

namespace Application\Command;

class MyProfileSave extends \System\Core\Command{

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$user->setName($this->req['name']);
		$user->setFamily($this->req['surname']);
		$user->setPatronymic($this->req['patronymic']);
		$user->setBirthday($this->req['birthday']);
		$user->setResidence($this->req['residence']);
		$user->setGender($this->req['gender']);
		$user->setStatusSys($this->req['user_system_status']);
		$user->setMail($this->req['mail']);
		$user->setTelephone($this->req['telephone']);

		$factory = \System\Orm\PersistenceFactory::getFactory('User');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$finder->insert($user);

		$session->set('user', $user);

		return $this->redirect("/cabinet/profile");
	}
}
