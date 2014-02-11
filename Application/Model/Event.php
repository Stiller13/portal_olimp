<?php
namespace Application\Model;

use System\Orm\DomainObject;

class Event extends DomainObject{
	
	private $title;
	private $description_public;
	private $description_private;
	private $event_type;
	private $confirm;           //требуется ли подтверждение
	private $confirm_description; //описание этого подтверждения
	private $partners;
	private $messagegroup; 		// как таковой пока нет, но обязательно появится

	
	public function setTitle($text){
		$this->title = $text;
		$this->markDirty();
	}

	public function getTitle(){
		return $this->title;
	}

	public function setDescription_public($text){
		$this->description_public = $text;
		$this->markDirty();
	}

	public function getDescription_public(){
		return $this->description_public;
	}

	public function setDescription_private($text){
		$this->description_private = $text;
		$this->markDirty();
	}

	public function getDescription_private(){
		return $this->description_private;
	}

	public function setEvent_type($type){ //функция settype в php уже есть, так что не будем его гневить
		$this->type = $type;
		$this->markDirty();
	}

	public function getEvent_type(){
		return $this->type;
	}

	public function setConfirm($conf){
		$this->confirm = $conf;
		$this->markDirty();
	}

	public function getConfirm(){
		return $this->confirm;
	}

	public function setConfirm_description($text){
		$this->confirm_description = $text;
		$this->markDirty();
	}

	public function getConfirm_description(){
		return $this->confirm_description;
	}

	public function setPartners(\Application\Orm\UserCollection $partners){
		$this->partners = $partners;
		$this->markDirty();
	}

	public function getPartners(){
		if (! isset($this->partners)){
			$this->partners = $this->getCollection($this->targetClass(), $this->getId());
		}
		return $this->partners;
	}

	public function setMessageGroup(\Application\Model\MessageGroup $mg){ //незакончено по известным причинам
		$this->messagegroup = $mg;
		$this->markDirty();
	}

	public function getMessageGroup(){ //незакочено по известным причинам
		return $this->messagegroup;
	}

	public function targetClass(){
		return 'Event';
	}

}
 
