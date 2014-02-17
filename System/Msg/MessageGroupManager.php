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

			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);
			$visit_idobj = $factory_visit->getIndentityObject();

			$visit_idobj->field('visit_user')->eq($user->getId());
			$visit_idobj->field('visit_group')->eq($group_id);

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

		$idobj->addWhat(array('messagegroup_id', 'messagegroup_partners', 'messagegroup_type', 'messagegroup_status'));
		$idobj->addJoin('INNER',array('messagegroup','user_userset'),array('messagegroup_partners','user_userset_userset_id'));
		$idobj->field('messagegroup_type')->eq($this->type_group);
		$idobj->field('user_userset_user_id')->eq($user_id);

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

		$factory_group = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_mg);

		if (!is_null($data['users'])) {
			$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
			$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);

			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);

			foreach ($data['users'] as $one_user) {
				$ruleobj = new \Application\Model\RuleObj();

				$ruleobj->setUser_id($one_user['id']);
				$ruleobj->setObj_id($new_mg->getId());
				$ruleobj->setRule(\System\Helper\Helper::getId("rule", $one_user["rule"]));
				$ruleobj->setObj_type(\System\Helper\Helper::getId("type", "messagegroup"));

				$ruleobj_finder->insert($ruleobj);

				$visit = new \Application\Model\Visit();
				$visit->setMessageGroupId($new_mg->getId());
				$visit->setUserId($one_user['id']);

				$visit_finder->insert($visit);
			}
		}

		return $new_mg->getId();
	}

	/**
	 * Отправить сообщение
	 */
	public function SendMessage($data) {
		$author = new \Application\Model\User();
		$author->setId($data['user_id']);

		$upload = \System\File\FileManager::upload_files();
		if (is_null($upload))
			$upload = new \Application\Orm\FileCollection();

		$new_message = new \Application\Model\Message();
		$new_message->setText($data['text']);
		$new_message->setAuthor($author);
		$new_message->setReMessage($data['id_remessage']);
		$new_message->setStatus($data['status']);
		$new_message->setGroup($data['group_id']);
		$new_message->setStatus($data['status']);

		$new_message->setFiles($upload);

		// Производим вставку
		$message_factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$message_finder = new \System\Orm\DomainObjectAssembler($message_factory);
		$message_finder->insert($new_message);

		$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
		$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);

		$visit = new \Application\Model\Visit();
		$visit->setMessageGroupId($data['group_id']);
		$visit->setUserId($data['user_id']);

		$visit_finder->insert($visit);
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