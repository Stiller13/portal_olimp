<?php
namespace System\Orm;

class DeleteFactory {
    function newDelete(IdentityObject $obj, $table){
        $core= 'DELETE FROM '.$table;
        list($where, $values)=$this->buildWhere($obj);
        return array($core." ".$where, $values);
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
}

?>