<?php

namespace Application\Command;

class MyMSPersonalGroupDelMe extends \System\Core\Command {

	protected function exec() {

		if ($this->req['secret_param'] === 's_e_cret_122') {
			$manager = \System\Msg\FactoryMGManager::getManager("system");
			$manager->delUser($this->req['group_id'], $this->req['user_id']);
		}

		return $this->redirect("/cabinet/message/personal");
	}

}