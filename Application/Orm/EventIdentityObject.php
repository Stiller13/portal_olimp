<?php

namespace Application\Orm;

class EventIdentityObject extends \System\Orm\IdentityObject{
    function __construct($field=null){
        parent::__construct($field, array('event_id','event_title','event_description_public', 'event_description_private', 'event_type', 'event_confirm', 'event_confirm_description', 'event_userset_id', 'event_messagegroup_id'));
    }
}



