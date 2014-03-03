<?php

namespace Application\Command;

class MyMSPersonalGroupCreate extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		if ($this->req["users"]){
			foreach ($this->req["users"] as $one_user_id) {
				$h[] = array(
					'id' => $one_user_id,
					'rule' => 'pmg_partner');
			}
		}

		$h[] = array(
			'id' => $user->getId(),
			'rule' => 'pmg_admin');
		
		$this->req['users'] = $h;
		$this->req['desc'] = "";

		$manager = \System\Msg\FactoryMGManager::getManager('personal');
		$new_mg_id = $manager->CreateGroup($this->req);

		return $this->redirect("/cabinet/message/personal/".$new_mg_id);
	}
}