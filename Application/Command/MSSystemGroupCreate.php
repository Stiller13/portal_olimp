<?php

namespace Application\Command;

class MSSystemGroupCreate extends \System\Core\Command {

    protected function exec() {
        $mg_type = "system";
        $manager = \System\Msg\FactoryMGManager::getManager($mg_type);

        $data = array();

        if ($this->req['mode'] === 'open') {
            $data['title'] = 'Системные оповещения';
            $data['description'] = $this->req['description']||"";
            $data['status'] = 5;//open
        } elseif ($this->req['mode'] === 'close') {
            $data['title'] = 'Системные сообщения пользователям';
            $data['description'] = $this->req['description']||"";
            $data['status'] = 6;//close

            $help = array();
            foreach ($this->req['users'] as $user_id) {
                $help[] = array(
                    'id' => $user_id,
                    'role' => 'partner');
            };
            $data['users'] = $help;
        }

        $mg_id = $manager->CreateGroup($data);

        if ($mg_id){
            return $this->redirect("/message/".$mg_type."/group/".$mg_id);
        }else {
            return $this->redirect("/message/".$mg_type);
        }
    }

}