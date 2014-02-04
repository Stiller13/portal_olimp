<?php

namespace System\Orm;

abstract class UpdateFactory{
	abstract function newUpdate(DomainObject $obj);
	protected function buildStatement($procedure,array $fields,$out=null){
	   $query="CALL {$procedure}( :";
	   if ($out){
		  $query.=implode(", :",array_keys($fields)).', @id)';
	   }
       else
		  $query.=implode(", :",array_keys($fields)).')';
          
		return array($query,$fields);
	}
}
?>