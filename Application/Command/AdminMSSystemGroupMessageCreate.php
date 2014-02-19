<?php

namespace Application\Command;

class AdminMSSystemGroupMessageCreate extends \System\Core\Command {

	protected function exec() {

		$mg_type = 'system';

		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);
		$manager->SendMessage($this->req);

		return $this->redirect("/admin_cabinet/message/system/".$this->req['group_id']);
	}
}