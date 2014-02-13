<?php

namespace Application\Orm;

class PersonalMessageGroupDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\PersonalMessageGroup();

		$obj->setId($array['messagegroup_id']);
		$obj->setMessages($this->createMessages($obj->getId()));
		$obj->setStatus($array['messagegroup_status']);
		$obj->setUserset($array['messagegroup_partners']);
		$obj->setPartners($this->createPartners($array['messagegroup_partners']));
		$obj->setVisit($this->createVisit($array['messagegroup_id']));

		return $obj;
	}

	public function createPartners($userset_id){
		$factory = \System\Orm\PersistenceFactory::getFactory('User');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();

		$idobj->addJoin('INNER',array('user', 'user_userset'), array('user_id', 'user_userset_user_id'));
		$idobj->field('user_userset_userset_id')->eq($userset_id);

		return $finder->find($idobj, 'user');
	}

	public function createMessages($group_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();
		$idobj->field('message_group')->eq($group_id);

		return $finder->find($idobj, 'message');
	}

	public function createVisit($group_id) {
		//Берем текущего пользователя системы
		$session = new \System\Session\Session();
		$user = $session->get('user');

		$factory = \System\Orm\PersistenceFactory::getFactory('Visit');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('visit_group')->eq($group_id);
		$idobj->field('visit_user')->eq($user->getId());

		$visit = $finder->findOne($idobj, 'visit');
		if (!$visit)
			$visit = new \Application\Model\Visit();

		return $visit;
	}

	public  function targetClass() {
		return "PersonalMessageGroup";
	}
}

?>