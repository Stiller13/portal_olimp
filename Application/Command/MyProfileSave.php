<?php

namespace Application\Command;

class MyProfileSave extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		if ($this->req['name']) {
			$user->setName($this->req['name']);
		}

		if ($this->req['surname']) {
			$user->setFamily($this->req['surname']);
		}

		if ($this->req['patronymic']) {
			$user->setPatronymic($this->req['patronymic']);
		}

		$factory = \System\Orm\PersistenceFactory::getFactory('User');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$finder->insert($user);

		$session->set('user', $user);

		return $this->redirect("/cabinet/profile");
	}
}
