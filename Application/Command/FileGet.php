<?php

namespace Application\Command;

class FileGet extends \System\Core\Command {

	protected function exec() {
		$data = \System\File\FileManager::download_file($this->data["code"]);
		// return $this->render(array("event" => $event, "user" => $user));

		return $this->getfile($data["path"], $data["name"]);
	}
}
