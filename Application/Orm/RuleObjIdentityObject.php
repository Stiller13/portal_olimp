<?php
namespace Application\Orm;

class RuleObjIdentityObject extends \System\Orm\IdentityObject{
    function __construct($field=null){
        parent::__construct($field, array('user_id','object_id','object_name','rule', 'object_type'));
    }
}

?>
