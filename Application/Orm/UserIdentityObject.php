<?php

namespace Application\Orm;

class UserIdentityObject extends \System\Orm\IdentityObject{
    function __construct($field=null){
        parent::__construct($field, array( 'userset_id', 'user_id','user_name','user_surname','user_patronymic','paper_id','journal_id'));
    }
}


?>