<?php

namespace Application\Command;

class MyMSPersonalGroupShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$manager = \System\Msg\FactoryMGManager::getManager("personal");
		$group = $manager->getGroup($this->data['mg_id']);
		// print_r($this->data['mg_id']);

		//Для добавления участников
		$factory_user = \System\Orm\PersistenceFactory::getFactory('User');
		$finder_user = new \System\Orm\DomainObjectAssembler($factory_user);
		$idobj = $factory_user->getIndentityObject();
		$idobj->addOrder(array('user_name'=>'ASC'));
		$user_list = $finder_user->find($idobj, 'user');

		$type = \System\Helper\Helper::getId("typegroup", "personal");
		$personal_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));

		$type = \System\Helper\Helper::getId("typegroup", "system");
		$system_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));;

		$type = \System\Helper\Helper::getId("typegroup", "notice");
		$notice_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));

		return $this->render(array("user" => $user, "group" => $group, "user_list" => $user_list, "personal_mess" => $personal_mess, "system_mess" => $system_mess, "notice_mess" => $notice_mess));
	}
}