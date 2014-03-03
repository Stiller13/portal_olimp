<?php

namespace Application\Model;

/**
 * @author Zalutskii
 * @version 24.12.13
 * Класс личной переписки
 */

class PersonalMessageGroup extends \System\Msg\MessageGroup {

	public function targetClass() {
		return 'PersonalMessageGroup';
	}

	public function getCountNewMessage() {
		$session = new \System\Session\Session();
		$user = $session->get('user');

		if ($user){
			return \System\Msg\VisitManager::getCountMess(array("for" => "group", "user_id" => $user->getId(), "group_id" => $this->getId()));
		} else {
			return 0;
		}
	}

}

?>