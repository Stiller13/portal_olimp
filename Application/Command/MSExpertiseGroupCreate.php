<?php

namespace Application\Command;

class MSExpertiseGroupCreate extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');

		$mg_type = "expertise";
		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);

		$data = array();
		$data['title'] = 'Экспертиза '.$this->req['title'];
		$data['description'] = $this->req['description'];
		$data['status'] = 6;//close

		$hd[] = array(
			'id' => $user->getId(),
			'role' => 'author'
		);
		//Назначае экспертов
		$hd[] = array(
			'id' => 13,
			'role' => 'expert'
		);
		$data['users'] = $hd;

		$mg_id = $manager->CreateGroup($data);

		if ($mg_id){
			$data = array(
				'text' => 'Экспертиза создана. Необходимо отправить документ',
				'group_id' => $mg_id,
				'author_id' => -1
			);
			$manager->SendMessage($data);

			return $this->redirect("/message/".$mg_type."/group/".$mg_id);
		}else {
			return $this->redirect("/message/".$mg_type);
		}
	}

}