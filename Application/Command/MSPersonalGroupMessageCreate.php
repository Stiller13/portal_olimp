<?php

namespace Application\Command;

class MSPersonalGroupMessageCreate extends \System\Core\Command {

	protected function exec() {

		$mg_type = 'personal';

		if ($this->req['secret_param'] === 'top_secret!') {
			$manager = \System\Msg\FactoryMGManager::getManager($mg_type);
			$manager->SendMessage($this->req);
		}

		return $this->redirect("/cabinet/message/personal/".$this->req['group_id']);
	}
}