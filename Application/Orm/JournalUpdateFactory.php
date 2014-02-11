<?php
namespace Application\Orm;

class JournalUpdateFactory extends \System\Orm\UpdateFactory{
    function newUpdate(\app\models\DomainObject $obj){
        //ѕроверку типов желательно добавить
        $id= $obj->getId();
        $cond=null;
        $values['title']=$obj->getTitle();
        if ($id >-1){
            $cond['id']=$id;
            return $this->buildStatement('journal',$values,$cond);
        }
        return $this->buildStatement('journal',$values,$cond,true);
    }
    
    function InsertLink(\app\models\DomainObject $obj){
        $papers=$obj->getPapers();
        $links= array('journal_id','paper_id'); 
        $query=$this->buildLinks('journal_paper',$links);
        foreach ($papers as $paper){
            $values[]=array($obj->getId(),$paper->getId());
        }  
        return array($query,$values);
    }
}

?>