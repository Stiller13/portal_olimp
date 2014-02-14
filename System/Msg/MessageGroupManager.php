<?php

namespace System\Msg;

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
	 * Тип группы строкой
	 * @var string
	 * не помню для чего
	 */
	protected $type_group_name;

	/**
	 * Название класса группы
	 * @var string
	 */
	protected $group_class_name;

	/**
	 * Роли участников нгруппы
	 * @var array
	 */
	protected $roles_map;

	function __construct($type, $class_name, $roles_map) {
		$this->type_group = $type;
		$this->group_class_name = $class_name;
		$this->roles_map = $roles_map;
	}

	/**
	 * Получить ролеь участника группы
	 * @return integer
	 */
	public function getRole($key){

		return $this->roles_map[$key];
	}

	/**
	 * Получить группу по id
	 * @return MessageGroup
	 */
	public function getGroup($group_id, $v_update = true) {
		$factory = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('message_group_type')->eq($this->type_group);
		$idobj->field('message_group_id')->eq($group_id);

		$group = $finder->findOne($idobj, 'message_group');

		// Апдейтим время посещения группы
		if ($v_update) {
			$session = new \System\Session\Session();
			$user = $session->get('user');

			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);
			$visit_idobj = $factory_visit->getIndentityObject();

			$visit_idobj->field('user_id')->eq($user->getId());
			$visit_idobj->field('visit_message_group_id')->eq($group_id);

			$visit = $visit_finder->findOne($visit_idobj, 'visit');

			if (!$visit) {
				$visit = new \Application\Model\Visit();
				$visit->addUserId($user->getId());
				$visit->setMessageGroupId($group_id);
			}
			$visit_finder->insert($visit);
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

		$idobj->addWhat(array('message_group_id', 'message_group_title', 'message_group_description', 'message_group_partners', 'message_group_type', 'message_group_status'));
		$idobj->addJoin('INNER',array('message_group','user_userset'),array('message_group_partners','userset_id'));
		$idobj->field('message_group_type')->eq($this->type_group);
		$idobj->field('user_id')->eq($user_id);

		return $finder->find($idobj, 'message_group');
	}

	/**
	 * Создать группу
	 * @return integer id группы
	 */
	public function CreateGroup($data) {
		$partners = new \Application\Orm\UserCollection();

		if (!is_null($data['users'])) {
			$visit = new \Application\Model\Visit();

			foreach ($data['users'] as $one_user) {
				$new_user = new \Application\Model\User();

				$new_user->setId($one_user['id']);
				$new_user->setRoleInGroup($this->getRole($one_user['role']));
				$partners->add($new_user);

				$visit->addUserId($one_user['id']);
			}
		}

		$class_name = '\Application\Model\\'.$this->group_class_name;
		$new_mg = new $class_name();

		$new_mg->setTitle($data['title']);
		$new_mg->setDescription($data['description']);
		$new_mg->setStatus($data['status']);

		$new_mg->setPartners($partners);

		$factory_group = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_mg);

		if ($visit) {
			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);

			$visit->setMessageGroupId($new_mg->getId());
			$visit_finder->insert($visit);
		}

		return $new_mg->getId();
	}

	/**
	 * Отправить сообщение
	 */
	public function SendMessage($data) {
		// Создаем автора
		$author = new \Application\Model\User();
		$author->setId($data['author_id']);

		if (is_null($data['upload']))
			$data['upload'] = new \Application\Orm\FileCollection();

		$new_message = new \Application\Model\Message();
		$new_message->setText($data['text']);
		$new_message->setAuthor($author);
		$new_message->setGroup($data['group_id']);
		$new_message->setFiles($data['upload']);

		// Производим вставку
		$message_factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$message_finder = new \System\Orm\DomainObjectAssembler($message_factory);
		$message_finder->insert($new_message);

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