<?php

namespace Application\Orm;

class AccountIdentityObject extends \System\Orm\IdentityObject{
    function __construct($field=null){
        parent::__construct($field, array('account_id','account_login','account_password', 'account_salt'));
    }
}


?>
