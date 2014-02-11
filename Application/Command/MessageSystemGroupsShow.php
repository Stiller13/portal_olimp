<?php

namespace Application\Command;

class MessageSystemGroupsShow extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');

		$manager = \System\Msg\FactoryMGManager::getManager($this->data['mg_type']);
		$listgroup = $manager->getGroupsForUser($user->getId());

		switch ($this->data['mg_type']) {
			case 'personal':
				$title = 'Личная переписка';
				break;
			case 'system':
				$title = 'Системные';
				break;
			case 'comment':
				$title = 'Комментарии';
				break;
			case 'expertise':
				$title = 'Экспертизы';
				break;
		}

		return $this->render(array(
			'listgroup' => $listgroup,
			'user' => $user,
			'title' => $title,
			'mg_type' => $this->data['mg_type']));
	}

}

?>