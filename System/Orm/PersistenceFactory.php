<?php
namespace System\Orm;

class PersistenceFactory {
    private $type;
    
    private function __construct($type){
        $this->type=$type;
    }
    public static function getFactory($type){
        return new PersistenceFactory($type);     
    }
    
    public function getCollection(array $raw=null){
        $collection= "\Application\Orm\\".$this->type."Collection";
        if(class_exists($collection)){
            return new $collection($raw,$this->getDomainObjectFactory());
        }
        throw new \Exception( "Unknown: $collection" );        
    }
    
    public function getDefferedCollection(\PDOStatement $stmt_handle, array $value_array){
        $collection= "\Application\Orm\Deferred".$this->type."Collection";
        if(class_exists($collection)){
            return new $collection($this->getDomainObjectFactory(),$stmt_handle,$value_array);
        }
        throw new \Exception( "Unknown: $collection" );      
    }
    public function getDomainObjectFactory(){
        $DomainObjectFactory= "\Application\Orm\\".$this->type."DomainObjectFactory"; 
        if(class_exists($DomainObjectFactory)){
            return new $DomainObjectFactory;
        }
        throw new \Exception( "Unknown: $DomainObjectFactory" );  
             
    }
    public function getIndentityObject(){
        $idobj="\Application\Orm\\".$this->type."IdentityObject";
        if(class_exists($idobj)){
            return new $idobj;
        }
        throw new \Exception( "Unknown: $idobj" );      
    }
    public function getSelectionFactory(){
        return new SelectionFactory();     
    }
    
    public function getDeleteFactory(){
        return new DeleteFactory();     
    }
    
    public function getUpdateFactory(){
        $update="\Application\Orm\\".$this->type."UpdateFactory";
        if(class_exists($update)){
            return new $update;
        }
        throw new \Exception( "Unknown: $update" );     
    }
    
    public function getType(){
        return $this->type;
    }
}


?>