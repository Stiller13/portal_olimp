<?php

namespace Application\Orm;

class StatusObjIdentityObject extends \System\Orm\IdentityObject{
    function __construct($field=null){
        parent::__construct($field, array('object_id','type_object_map_name','status', 'object_type')); 
    }
}


?>
