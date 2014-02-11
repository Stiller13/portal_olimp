<?php

namespace Application\Command;

/**
 * Команда настроек группы
 * @author Zalutskii
 * @version 19.10.13
 */

use PDO;

class MessageSystemGroupSettingsShow extends \System\Core\Command {
	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');
		$user_id = $user->getId();

		$manager = \System\Msg\FactoryMGManager::getManager($this->data['mg_type']);
		$messagegroup = $manager->getGroup($this->data["mg_id"]);

		$DBH=\System\Core\DbConn::getPDO();
//      получим пользователей не включенных в группу
		$group_id = $messagegroup->getId();
		$STH = $DBH->query("SELECT `user`.`user_id`, `user`.`user_name`, `user`.`user_surname` FROM `user` WHERE `user`.`user_id` NOT IN (SELECT `user_id` FROM `user_userset` JOIN `message_group` ON `userset_id` = `message_group_partners` WHERE `message_group_id`='$group_id')");
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		$STH->execute();
		$users=array();
		while($row=$STH->fetch())
			$users[]=$row;

		return $this->render(array("messagegroup" => $messagegroup, "user" => $user, "users" => $users));
	}
}