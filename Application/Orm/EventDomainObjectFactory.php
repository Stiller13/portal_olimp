<?php

namespace Application\Orm;

class EventDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	function doCreateObject(array $array) {
		$obj= new \Application\Model\Event();

		$obj->setId($array['event_id']);
		$obj->setTitle($array['event_title']);
		$obj->setDescription_public($array['event_description_public']);
		$obj->setDescription_private($array['event_description_private']);
		$obj->setEvent_type(\System\Helper\Helper::getName("type_event", $array['event_type']));
		$obj->setConfirm($array['event_confirm']);
		$obj->setConfirm_description($array['event_confirm_description']);
		$obj->setPartners($this->createCollection($array['event_userset_id'])); //??? может прокатит, не уверен
		$obj->setComments($this->createComments($array['event_id']));
		$obj->setNoticeGroups($this->createNoticeGroups($array['event_id']));
		$obj->setFiles($this->createFiles($array['event_id']));

		return $obj;
	}

	function createCollection($id){
		$factory= \System\Orm\PersistenceFactory::getFactory('User');
		$finder= new \System\Orm\DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();

		$idobj->addJoin('INNER',array('user','user_userset'),array('user_id','user_userset_user_id'));
		$idobj->field('user_userset_userset_id')->eq($id);

		return $partners=$finder->find($idobj,'user');
	}

	public function createPartners($userset_id){
		$factory = \System\Orm\PersistenceFactory::getFactory('User');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();

		$idobj->addJoin('INNER',array('user', 'user_userset'), array('user_id', 'user_userset_user_id'));
		$idobj->field('user_userset_userset_id')->eq($userset_id);

		return $finder->find($idobj, 'user');
	}

	public function createComments($event_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('CommentMessageGroup');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();

		$idobj->addJoin('INNER',array('messagegroup', 'event_mg'), array('messagegroup_id', 'event_mg_group'));
		$idobj->field('event_mg_event')->eq($event_id);
		$idobj->field('messagegroup_type')->eq(\System\Helper\Helper::getId("typegroup", "comment"));

		return $finder->findOne($idobj, 'messagegroup');
	}

	public function createNoticeGroups($event_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('NoticeMessageGroup');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();

		$idobj->addJoin('INNER',array('messagegroup', 'event_mg'), array('messagegroup_id', 'event_mg_group'));
		$idobj->field('event_mg_event')->eq($event_id);
		$idobj->field('messagegroup_type')->eq(\System\Helper\Helper::getId("typegroup", "notice"));

		return $finder->find($idobj, 'messagegroup');
	}

	public function createFiles($event_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('File');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();

		$idobj->addJoin('INNER', array('file', 'event_file'), array('file_id', 'event_file_file'));
		$idobj->field('event_file_event')->eq($event_id);

		return $finder->find($idobj, 'file');
	}

	function targetClass(){
		return "Event";
	}
}

