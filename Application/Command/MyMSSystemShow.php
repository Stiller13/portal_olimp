<?php

namespace Application\Command;

use System\Helper\Helper;

class MyMSSystemShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$factory_group = \System\Orm\PersistenceFactory::getFactory('PersonalMessageGroup');
		$finder_group = new \System\Orm\DomainObjectAssembler($factory_group);
		$idobj = $factory_group->getIndentityObject();

		$idobj->field('messagegroup_type')->eq(Helper::getId("typegroup", "system"));
		$idobj->field('messagegroup_status')->eq(Helper::getId("status", "open"));

		$group = $finder_group->findOne($idobj, 'messagegroup');

		if ($group) {
			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);
			$visit_idobj = $factory_visit->getIndentityObject();

			$visit_idobj->field('visit_user')->eq($user->getId());
			$visit_idobj->field('visit_group')->eq($group->getId());

			$visit = $visit_finder->findOne($visit_idobj, 'visit');

			//На всякий случай проверка
			if (!$visit) {
				$visit = new \Application\Model\Visit();
				$visit->setUserId($user->getId());
				$visit->setMessageGroupId($group->getId());
			}
			$visit_finder->insert($visit);
		}

		//Количество непрочитанных
		$factory = \System\Orm\PersistenceFactory::getFactory('PersonalMessageGroup');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->addWhat(array('messagegroup_id', 'messagegroup_partners', 'messagegroup_type', 'messagegroup_status'));
		$idobj->addJoin('INNER',array('messagegroup','user_userset'),array('messagegroup_partners','user_userset_userset_id'));
		$idobj->field('messagegroup_type')->eq(Helper::getId("typegroup", "personal"));
		$idobj->field('user_userset_user_id')->eq($user->getId());

		$list_group = $finder->find($idobj, 'messagegroup');

		$personal_mess = 0;
		foreach ($list_group as $one_group) {
			$personal_mess += $one_group->getVisit()->getCountMessage();
		}


		return $this->render(array("user" => $user, "list_mes" => $group, "personal_mess" => $personal_mess));
	}
}