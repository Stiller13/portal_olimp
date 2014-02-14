<?php

namespace Application\Orm;

class EventDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	function doCreateObject(array $array) {
		$obj= new \Application\Model\Event();

		$obj->setTitle($array['event_title']);
		$obj->setDescription_public($array['event_description_public']);
		$obj->setDescription_private($array['event_description_private']);
		$obj->setEvent_type($array['event_type']);
		$obj->setConfirm($array['event_confirm']);
		$obj->setConfirm_description($array['event_confirm_description']);
		$obj->setPartners($this->createCollection($array['event_userset_id'])); //??? может прокатит, не уверен
		// еще для messagegroup и partners, будут позже
		$obj->setId($array['event_id']);

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
	function targetClass(){
		return "Event";
	}
}

