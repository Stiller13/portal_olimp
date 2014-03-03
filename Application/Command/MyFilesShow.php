<?php

namespace Application\Command;

class MyFilesShow extends \System\Core\Command{

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory = \System\Orm\PersistenceFactory::getFactory('File');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->addJoin('INNER',array('file','user_file'),array('file_id','user_file_file'));
		$idobj->field('user_file_user')->eq($user->getId());

		$list_file = $finder->find($idobj,'file');

		return $this->render(array("user" => $user, "list_file" => $list_file));
	}
}
