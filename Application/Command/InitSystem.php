<?php

namespace Application\Command;

class InitSystem extends \System\Core\Command{

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$text = "";

		$manager = \System\Msg\FactoryMGManager::getManager("system");

		$text .= "Системные сообщения...";
		$text .= $manager->Init() > 0?"ok<br>":"error<br>";


		$manager = \System\Msg\FactoryMGManager::getManager("notice");

		$text .= "Системные оповещения...";
		$text .= $manager->Init() > 0?"ok<br>":"error<br>";

		$text .= "Аккаунт администратора...";

		$factory = \System\Orm\PersistenceFactory::getFactory('Account');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('account_login')->eq('admin');

		$account = $finder->findOne($idobj,'account');

		if (!$account) {
			$reg = new \System\Auth\Registration();

			if ($reg->register("admin", "admin", "admin") === 'Ok') {
				$idobj = $factory->getIndentityObject();

				$idobj->field('account_login')->eq('admin');

				$account = $finder->findOne($idobj,'account');
				$text .= "ok<br>";
			} else {
				$text .= "error<br>";
			}
		} else {
			$text .= "ok<br>";
		}

		$text .= "Роль администратора...";

		$factory = \System\Orm\PersistenceFactory::getFactory('UserRole');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('role_user')->eq($account->getId());

		$role = $finder->findOne($idobj, 'role');

		if (!$role) {
			$role = new \Application\Model\UserRole();
			$role->setUser_id($account->getId());
			$role->setRole("admin");

			$finder->insert($role);
		}

		$text .= $role->getId() > 0?"ok<br>":"error<br>";

		return $this->render(array("user" => $user, "text" => $text));
	}
}
