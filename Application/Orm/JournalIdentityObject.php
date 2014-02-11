<?php
require_once('IdentityObject.php');

class JournalIdentityObject extends \System\Orm\IdentityObject{
    function __construct($field=null){
        parent::__construct($field, array('id','title'));
    }
}

?>