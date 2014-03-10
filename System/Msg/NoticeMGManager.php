<?php

namespace System\Msg;

/**
 * @author Zalutskii
 * @version 24.12.13
 * Класс-менеджер группы коментариев
 */

class NoticeMGManager extends \System\Msg\MessageGroupManager {

	public function Init() {
			$factory = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
			$finder = new \System\Orm\DomainObjectAssembler($factory);
			$idobj = $factory->getIndentityObject();

			$idobj->field("messagegroup_status")->eq(\System\Helper\Helper::getId("status", "all_user"));
			$idobj->field("messagegroup_type")->eq(\System\Helper\Helper::getId("type", "notice"));

			$group = $finder->findOne($idobj, "messagegroup");

			if (!$group) {
				$class_name = '\Application\Model\\'.$this->group_class_name;
				$new_mg = new $class_name();

				$new_mg->setStatus("all_user");
				$new_mg->setDescription("Для всех пользователей");

				$finder->insert($new_mg);

				if ($new_mg->getId() > 0) {
					$factory_user = \System\Orm\PersistenceFactory::getFactory("MGUser");
					$user_finder = new \System\Orm\DomainObjectAssembler($factory_user);
					$user_io = $factory_user->getIndentityObject();

					$user_list = $user_finder->find($user_io, "user");

					foreach ($user_list as $one_user) {
						$this->addUser($new_mg->getId(), $one_user->getId(), "nmg_partner");
					}
					return 1;
				} else {
					return 0;
				}
			} else {
				return 1;
			}
		}
}

?>