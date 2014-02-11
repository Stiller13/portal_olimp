<?php

namespace Application\Command;

/**
 * @author Zalutskii
 * @version 22.12.13
 */

class MSExpertiseGroupOk extends \System\Core\Command {

    protected function exec() {

        $mg_type = 'expertise';
        $manager = \System\Msg\FactoryMGManager::getManager($mg_type);

        $data = array(
            'text' => 'Экспертиза закрыта',
            'group_id' => $this->data['mg_id'],
            'author_id' => -1//системное сообщение без автора
        );
        $manager->SendMessage($data);

        $data = array();
        $data['group_id'] = $this->data['mg_id'];
        $data['status'] = 3;

        $manager->setSettingsGroup($data);

        return $this->redirect("/message/".$mg_type."/group/".$this->data["mg_id"]);

    }

}