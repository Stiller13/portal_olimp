<?php

namespace Application\Orm;

class AccountIdentityObject extends \System\Orm\IdentityObject{
    function __construct($field=null){
        parent::__construct($field, array('user_id','authorization_login','authorization_password', 'authorization_salt'));
    }
}


?>
