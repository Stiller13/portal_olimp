<?php

namespace Application\Orm;

class DeferredFileCollection extends \Application\Orm\FileCollection{
    private $stmt;
    private $valueArray;
    private $run = false;

    function __construct(\System\Orm\DomainObjectFactory $dofact = null, \PDOStatement $stmt_handle, array $value_array) {
        parent::__construct(null,$dofact);
        $this->stmt= $stmt_handle;
        $this->valueArray= $value_array;
    }

    function notifyAccess() {
        if (! $this->run){
            $this->stmt->execute($this->valueArray);
            $this->raw= $this->stmt->fetchAll();
            $this->total = count($this->raw);
        }
        $this->run =true;
    }
}

?>