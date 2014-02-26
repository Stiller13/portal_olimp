<?php

namespace Application\Command;

class EventNewComment extends \System\Core\Command {

	protected function exec() {

		$mg_type = 'comment';

		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);
		$manager->SendMessage($this->req, false);

		return $this->redirect("/event/".$this->data['e_id']);
	}
}