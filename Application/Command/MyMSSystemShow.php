<?php

namespace Application\Command;

class MyMSSystemShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

/*		$factory_group = \System\Orm\PersistenceFactory::getFactory('SystemMessageGroup');
		$finder_group = new \System\Orm\DomainObjectAssembler($factory_group);
		$idobj = $factory_group->getIndentityObject();

		$idobj->field('messagegroup_type')->eq(Helper::getId("typegroup", "system"));
		$idobj->field('messagegroup_status')->eq(Helper::getId("status", "open"));

		$group = $finder_group->findOne($idobj, 'messagegroup');

		if ($group) {
			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);

			$visit = new \Application\Model\Visit();
			$visit->setUserId($user->getId());
			$visit->setMessageGroupId($group->getId());

			$visit_finder->insert($visit);
		}*/

		$manager = \System\Msg\FactoryMGManager::getManager("system");
		$list_groups = $manager->getGroupsForUser($user->getId());

		//Количество непрочитанных
		$manager = \System\Msg\FactoryMGManager::getManager("personal");
		$list_group = $manager->getGroupsForUser($user->getId());

		$personal_mess = 0;
		foreach ($list_group as $one_group) {
			$personal_mess += $one_group->getVisit()->getCountMessage();
		}

		return $this->render(array("user" => $user, "list_groups" => $list_groups, "personal_mess" => $personal_mess));
	}
}