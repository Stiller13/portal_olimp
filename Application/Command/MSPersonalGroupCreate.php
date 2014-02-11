<?php

namespace Application\Command;

class MSPersonalGroupCreate extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');

		$mg_type = "personal";
		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);

		$data = array();
		$data['title'] = $this->req['title'];
		$data['description'] = $this->req['description'];
		$data['status'] = 6;//close
		$hd[] = array(
			'id' => $user->getId(),
			'role' => 'admin'
		);
		$data['users'] = $hd;

		$mg_id = $manager->CreateGroup($data);

		if ($mg_id)
			return $this->redirect("/message/".$mg_type."/group/".$mg_id);
		else
			return $this->redirect("/message/".$mg_type);
	}

}