<?php

namespace Application\Command;

class MSPersonalGroupShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

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
		$user_list = $finder_user->find($idobj, 'user');

		//Количество непрочитанных
		$factory = \System\Orm\PersistenceFactory::getFactory('PersonalMessageGroup');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->addWhat(array('messagegroup_id', 'messagegroup_partners', 'messagegroup_type', 'messagegroup_status'));
		$idobj->addJoin('INNER',array('messagegroup','user_userset'),array('messagegroup_partners','user_userset_userset_id'));
		$idobj->field('messagegroup_type')->eq(1);
		$idobj->field('user_userset_user_id')->eq($user->getId());

		$list_group = $finder->find($idobj, 'messagegroup');

		$personal_mess = 0;
		foreach ($list_group as $group) {
			$personal_mess += $group->getVisit()->getCountMessage();
		}


		return $this->render(array("user" => $user, "group" => $group, "user_list" => $user_list, "personal_mess" => $personal_mess));
	}
}