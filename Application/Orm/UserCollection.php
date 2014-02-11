<?php

namespace Application\Orm;

class UserCollection extends \System\Orm\Collection{
    function targetClass(){
        return "User";
    }
}

?>