<?php

namespace Application\Orm;

class VisitIdentityObject extends \System\Orm\IdentityObject {

    function __construct($field = null) {
        parent::__construct($field, array(
            'id',
            'user_id',
            'visit_message_group_id',
            'visit_datetime',
            'visit_count_message',
            'messageset_id'));//For delete
    }
}


?>