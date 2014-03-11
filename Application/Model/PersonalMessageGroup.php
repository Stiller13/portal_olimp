<?php

namespace Application\Model;

/**
 * @author Zalutskii
 * @version 24.12.13
 * Класс личной переписки
 */

class PersonalMessageGroup extends \System\Msg\MessageGroup {

	private $count_new_message;

	public function getCountNewMessage() {
		if (!isset($this->count_new_message)) {
			$session = new \System\Session\Session();
			$user = $session->get('user');

			if ($user) {
				$this->count_new_message = \System\Msg\VisitManager::getCountMess(array("for" => "group", "user_id" => $user->getId(), "group_id" => $this->getId()));
			} else {
				$this->count_new_message = 0;
			}
		}

		return $this->count_new_message;
	}

	public function targetClass() {
		return 'PersonalMessageGroup';
	}

}

?>