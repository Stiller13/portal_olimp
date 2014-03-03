<?php

namespace Application\Orm;

class CommentMessageGroupDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\CommentMessageGroup();

		$obj->setId($array['messagegroup_id']);
		$obj->setStatus($array['messagegroup_status']);
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
		$idobj->field('message_message')->eq(0);

		return $finder->find($idobj, 'message');
	}

	public  function targetClass() {
		return "CommentMessageGroup";
	}
}

?>