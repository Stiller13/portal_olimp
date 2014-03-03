<?php

namespace Application\Orm;

class NoticeMessageGroupDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\NoticeMessageGroup();

		$obj->setId($array['messagegroup_id']);
		$obj->setStatus(\System\Helper\Helper::getName("status", $array['messagegroup_status']));
		$obj->setDescription($array['messagegroup_desc']);
		$obj->setMessages($this->createMessages($obj->getId()));
		$obj->setPartners(new \Application\Orm\MGUserCollection());

		return $obj;
	}

	public function createMessages($group_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();
		$idobj->field('message_group')->eq($group_id);

		return $finder->find($idobj, 'message');
	}

	public  function targetClass() {
		return "NoticeMessageGroup";
	}
}

?>