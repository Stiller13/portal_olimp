<?php

namespace Application\Command;

class MyMSPersonalGroupAddUsers extends \System\Core\Command {

	protected function exec() {

		if ($this->req['secret_param'] === 'top_s_e_cret') {
			$manager = \System\Msg\FactoryMGManager::getManager("system");

			foreach ($this->req['users'] as $id_user) {
				$manager->addUser($this->req['group_id'], $id_user, "pmg_partner");
			}
		}

		return $this->redirect("/cabinet/message/personal/".$this->req['group_id']);
	}

}