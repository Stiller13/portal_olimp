<?php

namespace Application\Command;

class EventNewNotice extends \System\Core\Command {

	protected function exec() {
		if ($this->req['text']) {
			$this->req['text'] = "Мероприятие <a href='/event/".$this->req["event_id"]."'>".$this->req["event_title"]."</a><hr>".$this->req['text'];

			$manager = \System\Msg\FactoryMGManager::getManager('notice');
			$manager->SendMessage($this->req, false);
		}

		return $this->redirect("/event/".$this->data['e_id']."/message/".$this->req['mode']);
	}
}