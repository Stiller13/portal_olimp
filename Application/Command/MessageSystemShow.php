<?php

namespace Application\Command;
/**
 * Команда отдачу файла сообщения
 * @author Zalutskii
 * @version 27.10.13
 */

class MessageSystemShow extends \System\Core\Command {

    protected function exec() {
        return $this->render();
    }
}