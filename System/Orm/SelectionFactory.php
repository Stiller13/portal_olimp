<?php
namespace System\Orm;

class SelectionFactory{
	function newSelection(IdentityObject $obj,$table){
	    $core=$this->buildWhat($obj,$table).' ';
        $core.=$obj->checkJoin();
        list($where, $values)=$this->buildWhere($obj);
        return array($core." ".$where.$obj->checkOrder().$obj->checkLimit(), $values);
	}
	
	function buildWhere(IdentityObject $obj){
		if ($obj->isVoid()){
			return array("",array());
		}
		$compstrings=array();
		$values=array();
		foreach ($obj->getComps() as $comp){
			$compstrings[]="{$comp['name']}{$comp['operator']}?";
			$values[]=$comp['value'];
		}
        if ($obj->returnLink()){
            $where=" WHERE ".implode(" AND ",$compstrings).' ';    
        } else {$where=" WHERE ".implode(" OR ",$compstrings).' ';}
		
		return array($where,$values);
	}
    
    function buildWhat(IdentityObject $obj, $table){
        $fields= $obj->checkWhat();
        $core=$core="SELECT $fields FROM $table";
        // xlog($core);
        return $core;
    }
}

?>