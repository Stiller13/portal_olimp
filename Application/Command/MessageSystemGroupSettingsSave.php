<?php

namespace Application\Command;

/**
 * Команда на сохранение настроек
 * @author Zalutskii
 * @version 29.01.14
 */

class MessageSystemGroupSettingsSave extends \System\Core\Command {

	protected function exec() {

		$data = array();
		$data['group_id'] = $this->data['mg_id'];
		$data['title'] = $this->req['title'];
		$data['description'] = $this->req['description'];

		$add_flag = true;
		foreach ($this->req['users'] as $user_id) {
			$help[] = array(
				'id' => $user_id,
				'role' => $_POST['admin'] == $user_id?'admin':'partner');
			if ($_POST['admin'] === $user_id)
				$add_flag = false;
		};

		if ($add_flag)
			$help[] = array('id' => $_POST['admin'], 'role' => 'admin');

		$data['users'] = $help;

		$manager = \System\Msg\FactoryMGManager::getManager($this->data['mg_type']);
		$manager->setSettingsGroup($data);

		return $this->redirect("/message/".$this->data["mg_type"]."/group/".$this->data["mg_id"]);
	}

}