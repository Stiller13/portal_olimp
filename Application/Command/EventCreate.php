<?php

namespace Application\Command;
use Application\Model\Event;

class EventCreate extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');		
		
		// просто показывает форму для внесения превоначальных настроек
		
		return $this->render(array("user" => $user));
	}
}

