<?php

namespace System\Orm;

class DomainObjectAssembler{
    protected static $pdo;
    protected $factory;
    private $statements= array();

    function __construct(PersistenceFactory $factory){
        $this->factory= $factory;
        if (!isset(self::$pdo)){
            // $base='test';
            // $user='root';
            // $password='';
            self::$pdo=\System\Core\DbConn::getPDO();
            // new \PDO("mysql:host=localhost;dbname=".$base,$user,$password);
            // self::$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            self::$pdo->prepare("set character_set_client='cp1251'")->execute();
            self::$pdo->prepare("set character_set_results='cp1251'")->execute();
            self::$pdo->prepare("set collation_connection='cp1251_general_ci'")->execute();
        }        
    }

    private function getStatement($str){
        if (! isset($this->statements[$str])){
            $this->statements[$str]=self::$pdo->prepare($str);
        }
        return $this->statements[$str];
    }
    
    function findOne(IdentityObject $idobj,$table){
        $collection= $this->find($idobj, $table);
        return $collection->next();
    }
    
    function find(IdentityObject $idobj, $table){
        $selfact= $this->factory->getSelectionFactory();
        list($selection, $values)= $selfact->newSelection($idobj,$table);
        $stmt= $this->getStatement($selection);
        //$stmt->execute($values);
        //$raw=$stmt->fetchAll();
        //echo $selection.'<br/>';
        return $this->factory->getDefferedCollection($stmt,$values);
    }
    
    function insert(DomainObject $obj){
        $upfact=$this->factory->getUpdateFactory();
        list($update, $values)= $upfact->newUpdate($obj);
        $stmt= $this->getStatement($update);
        //echo $update.'<br/>';
        foreach ($values as $key=>$value){
            $stmt->bindValue(':'.$key,$value);
        }
        $stmt->execute();
        $stmt->closeCursor();
        if ($obj->getId()<0){
            $output = self::$pdo->query("select @id")->fetch(\PDO::FETCH_ASSOC);
            $obj->setId($output['@id']);
        }
        $obj->markClean();
    }
    
    function delete(IdentityObject $obj, $table){
        $delfact= $this->factory->getDeleteFactory();
        list($delete, $values)= $delfact->newDelete($obj,$table);
        $stmt= $this->getStatement($delete);
        $stmt->execute($values);
    }
    
}
?>