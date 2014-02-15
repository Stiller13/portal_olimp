<?php

namespace Application\Command;

class FileGet extends \System\Core\Command {

	protected function exec() {
		\System\File\FileManager::download_file($this->data["code"]);
		// return $this->render(array("event" => $event, "user" => $user));
	}
}
