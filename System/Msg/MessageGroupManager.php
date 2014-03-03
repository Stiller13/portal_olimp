<?php

namespace System\Msg;

use \System\Helper;

/**
 * @author Zalutskii
 * @version 29.01.14
 */

abstract class MessageGroupManager {
	/**
	 * Тип группы для БД
	 * @var integer
	 */
	protected $type_group;

	/**
	 * Название класса группы
	 * @var string
	 */
	protected $group_class_name;

	function __construct($type, $class_name) {
		$this->type_group = $type;
		$this->group_class_name = $class_name;
	}

	/**
	 * Получить группу по id
	 * @return MessageGroup
	 */
	public function getGroup($group_id, $v_update = true) {
		$factory = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('messagegroup_type')->eq($this->type_group);
		$idobj->field('messagegroup_id')->eq($group_id);

		$group = $finder->findOne($idobj, 'messagegroup');

		// Апдейтим время посещения группы
		if ($v_update) {
			$session = new \System\Session\Session();
			$user = $session->get('user');

			VisitManager::updateVisit(array("user_id" => $user->getId(), "group_id" => $group_id));
		}

		return $group;
	}

	/**
	 * Получить группы по id пользователя-участника
	 * @return MessageGroupCollection
	 */
	public function getGroupsForUser($user_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		// $idobj->addWhat(array('messagegroup_id', 'messagegroup_partners', 'messagegroup_type', 'messagegroup_status', 'messagegroup_desc'));
		$idobj->addJoin('INNER',array('messagegroup','messagegroup_user'),array('messagegroup_id','messagegroup_user_group'));
		$idobj->field('messagegroup_type')->eq($this->type_group);
		$idobj->field('messagegroup_user_user')->eq($user_id);

		return $finder->find($idobj, 'messagegroup');
	}

	/**
	 * Создать группу
	 * @return integer id группы
	 */
	public function CreateGroup($data) {
		$class_name = '\Application\Model\\'.$this->group_class_name;
		$new_mg = new $class_name();

		$new_mg->setStatus($data['status']);
		$new_mg->setDescription($data['desc']);

		$factory_group = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_mg);

		if (!is_null($data["users"])) {
			foreach ($data["users"] as $one_user) {
				$this->addUser($new_mg->getId(), $one_user["id"], $one_user["rule"]);
			}
		}

		return $new_mg->getId();
	}

	/**
	 * Добавить пользователя в группу
	 */
	public function addUser($group_id, $user_id, $rule) {
		$factory = \System\Orm\PersistenceFactory::getFactory('MGUser');
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$mguser = new \Application\Model\MGUser();

		$mguser->setID($user_id);
		$mguser->setGroup($group_id);
		$mguser->setRule($rule);

		$finder->insert($mguser);
	}

	/**
	 * Удалить пользователя из группы
	 */
	public function delUser($group_id, $user_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('MGUser');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('messagegroup_user_group')->eq($group_id);
		$idobj->field('messagegroup_user_user')->eq($user_id);

		$finder->delete($idobj, 'messagegroup_user');
	}

	/**
	 * Отправить сообщение
	 */
	public function SendMessage($data, $v_update = true) {
		$author = new \Application\Model\User();
		$author->setId($data['user_id']);

		$upload = \System\File\FileManager::upload_files();
		if (is_null($upload))
			$upload = new \Application\Orm\FileCollection();

		if (!$data['status'])
			$data['status'] = 0;

		if (!$data['id_remessage'])
			$data['id_remessage'] = 0;

		$new_message = new \Application\Model\Message();
		$new_message->setText($data['text']);
		$new_message->setAuthor($author);
		$new_message->setReMessage($data['id_remessage']);
		$new_message->setStatus($data['status']);
		$new_message->setGroup($data['group_id']);
		$new_message->setFiles($upload);

		// Производим вставку
		$message_factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$message_finder = new \System\Orm\DomainObjectAssembler($message_factory);
		$message_finder->insert($new_message);

		if ($v_update) {
			VisitManager::updateVisit(array("user_id" => $data['user_id'], "group_id" => $data['group_id']));
		}
	}

	/**
	 * Задать настройки группы
	 */
	public function setSettingsGroup($data) {
		if (is_null($data['group_id']))
			break;

		$factory_group = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_idobj = $factory_group->getIndentityObject();

		$group_idobj->field('message_group_type')->eq($this->type_group);
		$group_idobj->field('message_group_id')->eq($data['group_id']);

		$group = $group_finder->findOne($group_idobj, 'message_group');

		if (is_null($group))
			break;

		if (!is_null($data['status']))
			$group->setStatus($data['status']);

		if (!is_null($data['title']))
			$group->setTitle($data['title']);

		if (!is_null($data['description']))
			$group->setDescription($data['description']);

		if (!is_null($data['users'])) {
			//Формируем новую коллекцию участников
			$new_users = new \Application\Orm\UserCollection();
			//Списки id новых и старых участников
			$new_users_id = array();
			$old_users_id = array();

			foreach ($data['users'] as $one_user) {
				$new_user = new \Application\Model\User();

				$new_user->setId($one_user['id']);
				$new_user->setRoleInGroup($this->getRole($one_user['role']));
				$new_users->add($new_user);

				$new_users_id[] = $one_user['id'];
			}

			foreach ($group->getPartners() as $one_partner)
				$old_users_id[] = $one_partner->getId();

			//Обновляем Visit-ы
			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);

			$add_users_id = array_diff($new_users_id, $old_users_id);
			if (!empty($add_users_id)) {
				$add_visit = new \Application\Model\Visit();
				$add_visit->setMessageGroupId($group->getId());
				$add_visit->setUsersId($add_users_id);

				$visit_finder->insert($add_visit);
			}

			$del_users_id = array_diff($old_users_id, $new_users_id);
			if (!empty($del_users_id))
				foreach ($del_users_id as $one_del_users_id) {
					$visit_idobj = $factory_visit->getIndentityObject();

					$visit_idobj->field('user_id')->eq($one_del_users_id);
					$visit_idobj->field('messageset_id')->eq($group->getId());

					$visit_finder->delete($visit_idobj, 'user_message_read');
				}

			$group->setPartners($new_users);
		}

		$group_finder->insert($group);

	}

}

?>