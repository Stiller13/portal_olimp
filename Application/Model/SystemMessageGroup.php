<?php

namespace Application\Model;

/**
 * @author Zalutskii
 * @version 29.01.14
 * Класс системных оповещений
 */

class SystemMessageGroup extends \Application\Model\PersonalMessageGroup {

    public function getTypeId() {
        return \System\Msg\FactoryMGManager::SYSTEM_GROUP;
    }

    public function targetClass() {
        return 'SystemMessageGroup';
    }
}

?>