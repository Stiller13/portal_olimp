<?php

namespace Application\Command;

class MSPersonalGroupsShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

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

		return $this->render(array("user" => $user, "list_group" => $list_group, "personal_mess" => $personal_mess));
	}
}