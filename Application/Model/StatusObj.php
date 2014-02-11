<?php
namespace Application\Model;

class StatusObj extends \System\Orm\DomainObject{
	private $obj_id;
	private $obj_type;
	private $obj_status;

	public function getObj_id(){
		return $this->obj_id;
	}

	public function getObj_type(){
		return $this->obj_type;
	}

	public function getObj_status(){
		return $this->obj_status;
	}

	public function setObj_id($obj_id){
		$this->obj_id = $obj_id;
		$this->markDirty();
	}

	public function setObj_type($obj_type){
		$this->obj_type = $obj_type;
		$this->markDirty();
	}

	public function setObj_status($obj_status){
		$this->obj_status = $obj_status;
		$this->markDirty();
	}

	public function targetClass(){
		return 'StatusObj';
	}
}
?>
