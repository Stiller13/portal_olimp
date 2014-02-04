<?php

namespace System\Orm;

 abstract class DomainObjectFactory{
    function createObject(array $array){
        $old=$this->getFromMap($array['id']);
        if ($old){
          //echo '????! </br>';
            return $old;
        }
        $obj= $this->doCreateObject($array);
        $this->addToMap($obj);
        $obj->markClean();
        return $obj;  
    }
    
    function createCollection($fact,$table1,$table2,$param1,$param2,$where_param,$param){
        $factory= PersistenceFactory::getFactory($fact);
        $finder= new DomainObjectAssembler($factory); 
        $idobj=$factory->getIndentityObject();
        $idobj->addJoin('INNER',array($table1,$table2),array($param1,$param2));
        $idobj->field($where_param)->eq($param);
        return $collection=$finder->find($idobj,$factory->getType());         
    }
    
    private function getFromMap($id){
        return ObjectWatcher::exists($this->targetClass(),$id);
    }
    
    private function addToMap(DomainObject $obj){
        return ObjectWatcher::add($obj);
    }
    
    abstract function doCreateObject(array $array);
    abstract function targetClass();
 } 
?>