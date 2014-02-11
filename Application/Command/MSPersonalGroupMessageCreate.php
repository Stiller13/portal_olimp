<?php

namespace Application\Command;

class MSPersonalGroupMessageCreate extends \System\Core\Command {

	protected function exec() {

		if ($this->req['secret_param'] === 'top_secret!') {
			$data = array();
			$data['text'] = $this->req['text'];
			$data['user_id'] = $this->req['user_id'];
			$data['group_id'] = $this->req['group_id'];
			$data['status'] = $this->req['status'];
			$data['id_remessage'] = $this->req['id_remessage'];

			$mg_type = 'personal';

			$manager = \System\Msg\FactoryMGManager::getManager($mg_type);
			$manager->SendMessage($data);
		}

		return $this->redirect("/cabinet/message/personal/".$this->req['group_id']);
	}
}