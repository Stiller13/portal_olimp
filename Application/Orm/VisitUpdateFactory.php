<?php

namespace Application\Orm;

class VisitUpdateFactory extends \System\Orm\UpdateFactory {

    public function newUpdate(\System\Orm\DomainObject $obj) {
        $id = $obj->getId();
        $users_id = $obj->getUsersId();

        $send_user_id = array();
        foreach ($users_id as $one_user_id) {
            $send_user_id[] = $one_user_id;
        }
        $values['users'] = implode(',', $send_user_id);

        $values['message_group_id'] = $obj->getMessageGroupId();


        if ($id > -1) {
            return $this->buildStatement('update_visit', $values);
        }
        return $this->buildStatement('insert_visit', $values);
    }
}

?>