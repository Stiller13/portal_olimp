<?php

namespace Application\Model;

/**
 * Класс содержащий информацию о последнемм посещении пользователей группы
 * @author Zalutskii
 * @version 19.12.13
 */

class Visit extends \System\Orm\DomainObject {
    /**
     * Список id пользователей
     * @var array
     */
    private $users_id = array();

    /**
     * id группы
     * @var integer
     */
    private $message_group_id;

    /**
     * Дата последнего посещения
     * @var date
     */
    private $date_time;

    /**
     * Количество непрочитанных сообщений
     * @var integer
     */
    private $count_message;

    public function setUsersId($users_id) {
        $this->users_id = $users_id;
        $this->markDirty();
    }

    public function getUsersId() {
        return $this->users_id;
    }

    public function addUserId($new_user_id) {
        // $this->getUsersId()->add($new_user_id);
        $this->users_id[] = $new_user_id;
        $this->markDirty();
    }

    public function setMessageGroupId($message_group_id) {
        $this->message_group_id = $message_group_id;
        $this->markDirty();
    }

    public function getMessageGroupId() {
        return $this->message_group_id;
    }

    public function setDate($date) {
        $this->date_time = $date;
        $this->markDirty();
    }

    public function getDate() {
        return $this->date_time;
    }

    public function setCountMessage($count) {
         $this->count_message = $count;
         $this->markDirty();
    }

    public function getCountMessage() {
        return $this->count_message;
    }

    public function targetClass() {
        return 'Visit';
    }

}

?>