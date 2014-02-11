<?php

namespace Application\Command;
/**
 * Команда отдачу файла сообщения
 * @author Zalutskii
* @version 22.01.14
 */

class MessageSystemFileGet extends \System\Core\Command {

    protected function exec() {
        \System\File\FileManager::download_file($this->data["code"]);
    }
}