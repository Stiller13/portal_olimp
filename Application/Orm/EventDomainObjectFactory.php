<?php

namespace Application\Orm;

class EventDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	public function doCreateObject(array $array) {
		$obj= new \Application\Model\Event();

		$obj->setId($array['event_id']);
		$obj->setTitle($array['event_title']);
		$obj->setDescription_public($array['event_description_public']);
		$obj->setDescription_private($array['event_description_private']);
		$obj->setEvent_type(\System\Helper\Helper::getName("type", $array['event_type']));
		$obj->setConfirm($array['event_confirm']);
		$obj->setConfirm_description($array['event_confirm_description']);
		$obj->setPartners($this->createPartners($array['event_id']));
		$obj->setComments($this->createComments($array['event_id']));
		$obj->setNoticeGroups($this->createNoticeGroups($array['event_id']));
		$obj->setFiles($this->createFiles($array['event_id']));
		$obj->setStatus(\System\Helper\Helper::getName("status", $array['event_status']));

		return $obj;
	}

	public function createPartners($event_id){
		$factory = \System\Orm\PersistenceFactory::getFactory('EUser');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->addJoin('INNER',array('user', 'event_user'), array('user_id', 'event_user_user'));
		$idobj->field('event_user_event')->eq($event_id);

		return $finder->find($idobj, 'user');
	}

	public function createComments($event_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('CommentMessageGroup');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->addJoin('INNER',array('messagegroup', 'event_mg'), array('messagegroup_id', 'event_mg_group'));
		$idobj->field('event_mg_event')->eq($event_id);
		$idobj->field('messagegroup_type')->eq(\System\Helper\Helper::getId("type", "comment"));

		return $finder->findOne($idobj, 'messagegroup');
	}

	public function createNoticeGroups($event_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('NoticeMessageGroup');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();

		$idobj->addJoin('INNER',array('messagegroup', 'event_mg'), array('messagegroup_id', 'event_mg_group'));
		$idobj->field('event_mg_event')->eq($event_id);
		$idobj->field('messagegroup_type')->eq(\System\Helper\Helper::getId("type", "notice"));

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

