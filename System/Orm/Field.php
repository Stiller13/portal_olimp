<?php
namespace System\Orm;

class Field{
	protected $name=null;
	protected $operator=null;
	protected $comps=array();
	protected $incomplete=false;
	
	function __construct($name){
		$this->name=$name;
	}
	
	function addTest($operator,$value){
		$this->comps[]=array('name'=>$this->name,'operator'=>$operator,'value'=>$value);
	}
	function getComps(){
		return $this->comps;
	}
	function isIncomplete(){
		return empty($this->comps);
	}
}
?>