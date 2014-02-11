<?php
namespace Application\Command;

/**
 * Команда на отправку сообщения
 * @author Zalutskii
 * @version 20.01.14
 */

class MessageSystemMessageCreate extends \System\Core\Command {

    protected function exec() {

        $manager = \System\Msg\FactoryMGManager::getManager($this->data["mg_type"]);
        $this->req['upload'] = \System\File\FileManager::upload_files();
        $manager->SendMessage($this->req);

        return $this->redirect("/message/".$this->data["mg_type"]."/group/".$this->data["mg_id"]);

    }
}