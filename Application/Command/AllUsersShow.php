<?php

namespace Application\Command;

class AllUsersShow extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');

		$factory_user = \System\Orm\PersistenceFactory::getFactory('User');
		$user_finder = new \System\Orm\DomainObjectAssembler($factory_user);
		$user_io = $factory_user->getIndentityObject();
		$user_io->addOrder(array('user_name'=>'ASC'));

		$user_list = $user_finder->find($user_io, 'user');

		return $this->render(array('user' => $user, 'user_list' => $user_list));
	}

}