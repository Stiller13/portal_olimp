<?php

namespace Application\Command;

class ProfileShow extends \System\Core\Command{

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory = \System\Orm\PersistenceFactory::getFactory('user');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('user_id')->eq($this->data['uid']);

		$profile = $finder->findOne($idobj, 'user');

		return $this->render(array("user" => $user, "profile" => $profile));
	}
}
