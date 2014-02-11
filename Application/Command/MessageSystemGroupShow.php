<?php

namespace Application\Command;

class MessageSystemGroupShow extends \System\Core\Command {
	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');

		$manager = \System\Msg\FactoryMGManager::getManager($this->data['mg_type']);
		$messagegroup = $manager->getGroup($this->data["mg_id"]);

		// print_r(\System\Msg\FactoryMGManager::$roles['personal']['admin']);

		switch ($this->data['mg_type']) {
			case 'personal':
				$view_name = 'MSPersonalGroupShow';
				break;
			case 'system':
				$view_name = 'MSSystemGroupShow';
				break;
			case 'expertise':
				switch ($messagegroup->getStatus()) {
					case 6:
						$view_name = 'MSExpertiseGroupShowClose';
						break;
					case 2:
						$view_name = 'MSExpertiseGroupShowExam';
						break;
					case 1:
						$view_name = 'MSExpertiseGroupShowDev';
						break;
					case 3:
						$view_name = 'MSExpertiseGroupShowConf';
						break;
					default:
						$view_name = 'MSExpertiseGroupShow';
					break;
				}
		}

		return $this->render(array("messagegroup" => $messagegroup, "user" => $user), $view_name);
	}

}

?>