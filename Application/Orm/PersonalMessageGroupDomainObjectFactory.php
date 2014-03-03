<?php

namespace Application\Orm;

class PersonalMessageGroupDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\PersonalMessageGroup();

		$obj->setId($array['messagegroup_id']);
		$obj->setStatus($array['messagegroup_status']);
		$obj->setDescription($array['messagegroup_desc']);
		$obj->setMessages($this->createMessages($obj->getId()));
		$obj->setPartners($this->createPartners($array['messagegroup_id']));

		return $obj;
	}

	public function createPartners($group_id){
		$factory = \System\Orm\PersistenceFactory::getFactory('MGUser');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();

		$idobj->addJoin('INNER',array('user', 'messagegroup_user'), array('user_id', 'messagegroup_user_user'));
		$idobj->field('messagegroup_user_group')->eq($group_id);

		return $finder->find($idobj, 'user');
	}

	public function createMessages($group_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();
		$idobj->field('message_group')->eq($group_id);

		return $finder->find($idobj, 'message');
	}

	public  function targetClass() {
		return "PersonalMessageGroup";
	}
}

?>