<?php

namespace Application\Orm;

class CommentMessageGroupIdentityObject extends \System\Orm\IdentityObject {

    function __construct($field=null){
        parent::__construct($field, array(
            'message_group_id',
            'message_group_title',
            'message_group_description',
            'message_group_partners',
            'message_group_type',
            'message_group_status',
            'userset_id',
            'user_id'));
    }
}

?>