<?php
namespace Application\Orm;

class PaperIdentityObject extends \System\Orm\IdentityObject{
    function __construct($field=null){
        parent::__construct($field, array('id','title','content','journal_id'));
    }
}

?>