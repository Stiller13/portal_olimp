<?php

namespace Application\Command;

class EventNewNotice extends \System\Core\Command {

	protected function exec() {
		if ($this->req['text']) {
			$mg_type = 'notice';

			$manager = \System\Msg\FactoryMGManager::getManager($mg_type);
			$manager->SendMessage($this->req, false);
		}

		return $this->redirect("/event/".$this->data['e_id']."/message/".$this->req['mode']);
	}
}