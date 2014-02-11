<?php

namespace Application\Command;

/**
 * @author Zalutskii
 * @version 22.12.13
 */

class MSExpertiseGroupReturn extends \System\Core\Command {

	protected function exec() {

		$mg_type = 'expertise';
		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);

		$manager->SendMessage($this->req);

		$group = $manager->getGroup($this->data['mg_id'], false);//без обновления visit-а

		$data = array(
			'text' => 'Документ возвращен на доработку',
			'group_id' => $group->getId(),
			'author_id' => -1//системное сообщение без автора
		);
		$manager->SendMessage($data);

		$settings = array(
			'group_id' => $group->getId(),
			'status' => 1//dev
		);
		$manager->setSettingsGroup($settings);

		return $this->redirect("/message/".$mg_type."/group/".$this->data["mg_id"]);

	}

}