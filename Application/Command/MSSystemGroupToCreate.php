<?php

namespace Application\Command;

use PDO;

class MSSystemGroupToCreate extends \System\Core\Command {

	protected function exec() {

		$factory = \System\Orm\PersistenceFactory::getFactory('SystemMessageGroup');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('message_group_type')->eq(\System\Msg\FactoryMGManager::$types['system']);
		$idobj->field('message_group_status')->eq(5);

		$open_groups = $finder->findOne($idobj, 'message_group');

		$new_open_group = count($open_groups) > 0?false:true;

		$session = new \System\Session\Session();
		$user = $session->get('user');
		$user_id = $user->getId();

		$DBH=\System\Core\DbConn::getPDO();
		$STH = $DBH->query("SELECT `user`.`user_id`, `user`.`user_name`, `user`.`user_surname` FROM `user`");// WHERE `user`.`user_id` <> '$user_id'");
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		$STH->execute();
		$user_list=array();
		while($row=$STH->fetch()){
			$user_list[]=$row;
		}

		return $this->render(array('new_open_group' => $new_open_group, 'user_list' => $user_list));

	}

}

?>