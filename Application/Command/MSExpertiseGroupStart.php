<?php

namespace Application\Command;

/**
 * @author Zalutskii
 * @version 22.12.13
 */

class MSExpertiseGroupStart extends \System\Core\Command {

	protected function exec() {

		$mg_type = 'expertise';
		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);

		$files = \System\File\FileManager::upload_files();

		if (count($files) > 0) {
			$this->req['upload'] = $files;
			$manager->SendMessage($this->req);

			$group = $manager->getGroup($this->data['mg_id'], false);//без обновления visit-а

			$data = array(
				'text' => 'Документ принят на экспертизу',
				'group_id' => $group->getId(),
				'author_id' => -1//системное сообщение без автора
			);
			$manager->SendMessage($data);

			$settings = array(
				'group_id' => $group->getId(),
				'status' => 2//exam
			);
			$manager->setSettingsGroup($settings);
		}

		return $this->redirect("/message/".$mg_type."/group/".$this->data["mg_id"]);
	}

}