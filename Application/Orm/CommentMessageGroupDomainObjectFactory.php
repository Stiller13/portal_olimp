<?php

namespace Application\Orm;

class CommentMessageGroupDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj = new \Application\Model\CommentMessageGroup();

		$obj->setId($array['messagegroup_id']);
		$obj->setStatus($array['messagegroup_status']);
		$obj->setDescription($array['messagegroup_desc']);
		$obj->setMessages($this->createMessages($obj->getId()));
		$obj->setPartners(new \Application\Orm\UserCollection());
		$obj->setVisit($this->createVisit($array['messagegroup_id']));

		return $obj;
	}

	public function createMessages($group_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('message_group')->eq($group_id);

		return $finder->find($idobj, 'message');
	}

	public function createVisit($group_id) {
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
		return "CommentMessageGroup";
	}
}

?>