<?php

namespace System\Orm;

use Exception;

abstract class Collection implements \Iterator{
    protected $dofact;
    protected $total=0;
    protected $raw= array();
    
    private $result;
    private $pointer=0;
    private $objects=array();
    
    function __construct(array $raw=null, \System\Orm\DomainObjectFactory $dofact=null){
        if (! is_null($raw) && ! is_null($dofact)){
            $this->raw=$raw;
            $this->total= count($raw);
        }
        $this->dofact=$dofact;
    }
    
    function add(\System\Orm\DomainObject $object){
        $class = "\Application\Model\\".$this->targetClass();
        if (! ($object instanceof $class)){
            throw new Exception ('??????? {$class}');
        }
        $this->notifyAccess();
        $this->objects[$this->total]=$object;
        $this->total++;
    }
    
    abstract function targetClass();
    
    protected function notifyAccess(){
        //????? ????????
    }
    
    private function getRow($num){
        $this->notifyAccess();
        if ($num>=$this->total){
            return null;
        }
        
        if (isset($this->objects[$num])){
            return $this->objects[$num];
        }
        
        if (isset($this->raw[$num])){
            $this->objects[$num]=$this->dofact->createObject($this->raw[$num]);
            return $this->objects[$num];
        }
    }
    
    public function rewind(){
        $this->pointer=0;
    }
    
    public function current(){
        return $this->getRow($this->pointer);
    }
    
    public function key(){
        return $this->pointer;
    }
    
    public function next(){
        $row=$this->getRow($this->pointer);
        if ($row){
            $this->pointer++;
        }
        return $row;
    }
    
    public function valid(){
        return(! is_null($this->current()));
    }
}
?>