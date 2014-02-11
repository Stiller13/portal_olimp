<?php

namespace Application\Command;

class MSPersonalGroupUnsubscribe extends \System\Core\Command {

    protected function exec() {
        $session = new \System\Session\Session();
        $user = $session->get('user');

        $mg_type = 'personal';
        $manager = \System\Msg\FactoryMGManager::getManager($mg_type);
        $messagegroup = $manager->getGroup($this->data["mg_id"]);

        $data = array();
        $data['group_id'] = $messagegroup->getId();
        $data['title'] = $messagegroup->getTitle();
        $data['description'] = $messagegroup->getDescription();
        $help = array();
        foreach ($messagegroup->getPartners() as $one_partner) {
            if ($one_partner->getId() !== $user->getId())
                $help[] = array(
                    'id' => $one_partner->getId(),
                    'role' => $one_partner->getRoleInGroup() == 11?'admin':'partner');
        };
        $data['users'] = $help;

        $manager->setSettingsGroup($data);

        return $this->redirect("/message/".$mg_type."/groups");
    }

}

?>