<?php

namespace Application\Command;

class NewsNewComment extends \System\Core\Command {

	protected function exec() {

		if ($this->req['text']) {
			$manager = \System\Msg\FactoryMGManager::getManager('comment');
			$manager->SendMessage($this->req, false);
		}

		return $this->redirect("/news/".$this->data['news_id']);
	}
}