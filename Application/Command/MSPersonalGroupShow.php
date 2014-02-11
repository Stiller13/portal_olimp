<?php

namespace Application\Command;

class MSPersonalGroupShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$mg_type = 'personal';

		$factory_group = \System\Orm\PersistenceFactory::getFactory('PersonalMessageGroup');
		$finder_group = new \System\Orm\DomainObjectAssembler($factory_group);
		$idobj = $factory_group->getIndentityObject();

		$idobj->field('messagegroup_id')->eq($this->data['mg_id']);

		$group = $finder_group->findOne($idobj, 'messagegroup');

		$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
		$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);
		$visit_idobj = $factory_visit->getIndentityObject();

		$visit_idobj->field('visit_user')->eq($user->getId());
		$visit_idobj->field('visit_group')->eq($group->getId());

		$visit = $visit_finder->findOne($visit_idobj, 'visit');

		if (!$visit) {
			$visit = new \Application\Model\Visit();
			$visit->setUserId($user->getId());
			$visit->setMessageGroupId($group->getId());
		}
		$visit_finder->insert($visit);

		//Для добавления участников
		$factory_user = \System\Orm\PersistenceFactory::getFactory('User');
		$finder_user = new \System\Orm\DomainObjectAssembler($factory_user);
		$idobj = $factory_user->getIndentityObject();
		$idobj->field('user_id')->neq($user->getId());
		$user_list = $finder_user->find($idobj, 'user');


		return $this->render(array("user" => $user, "group" => $group, "user_list" => $user_list));
	}
}