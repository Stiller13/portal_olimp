<?php

namespace Application\Command;

class EventChangePartners extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory = \System\Orm\PersistenceFactory::getFactory("Event");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("event_id")->eq($this->data["e_id"]);

		$event = $finder->findOne($idobj, "event");

		$group_all_id = $event->getNoticeGroup('all')->getId();
		$group_users_id = $event->getNoticeGroup('users')->getId();
		$group_partners_id = $event->getNoticeGroup('partners')->getId();

		$mg_type = 'notice';
		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);

		$factory_euser = \System\Orm\PersistenceFactory::getFactory("EUser");
		$finder_euser = new \System\Orm\DomainObjectAssembler($factory_euser);
		$idobj_euser = $factory_euser->getIndentityObject();

		$idobj_euser->field("event_user_rule")->eq(\System\Helper\Helper::getId("rule", "e_admin"));
		$idobj_euser->field("event_user_event")->eq($event->getId());

		$rule = $finder_euser->findOne($idobj_euser, 'event_user');

		foreach ($this->req["users"] as $user_id) {
			if ($rule && ($rule->getId() === $user_id)) {
				continue;
			}
			switch ($this->req["do"]) {
				case 'add':
					if ($event->getConfirm() === "1") {
						$upload = \System\File\FileManager::upload_files();//есть метод только на загрузку нескольких файлов

						foreach ($upload as $one_file) {
							$file = $one_file;
						}
						if ($file) {
							$factory = \System\Orm\PersistenceFactory::getFactory("UserFile");
							$finder = new \System\Orm\DomainObjectAssembler($factory);

							$userfile = new \Application\Model\UserFile();
							$userfile->setUser($user_id);
							$userfile->setFile($file->getId());

							$finder->insert($userfile);
						} else {
							return $this->render(array("message" => "Необходимо отправить файл", "type_message" => "alert-danger", "event" => $event, "user" => $user), "EventShow");
						}
					} else {
						$file = new \Application\Model\File();
					}

					$euser = new \Application\Model\EUser();

					$euser->setId($user_id);
					$euser->setEvent($event->getId());
					if ($event->getEvent_type() === "private"){
						$euser->setRule("e_user");
					} else {
						$euser->setRule("e_partner");
					}
					$euser->setFile($file);

					$finder_euser->insert($euser);

					if ($event->getEvent_type() === "private"){
						$manager->addUser($group_users_id, $user_id, "nmg_partner");
					} else {
						$manager->addUser($group_partners_id, $user_id, "nmg_partner");
					}
					$manager->addUser($group_all_id, $user_id, "nmg_partner");
					break;

				case 'del':
					$idobj_euser = $factory_euser->getIndentityObject();
					$idobj_euser->field("event_user_user")->eq($user_id);
					$idobj_euser->field("event_user_event")->eq($event->getId());

					$finder_euser->delete($idobj_euser, "event_user");

					$manager->delUser($group_all_id, $user_id);
					$manager->delUser($group_users_id, $user_id);
					$manager->delUser($group_partners_id, $user_id);
					break;

				case 'ok':
					$euser = new \Application\Model\EUser();

					$euser->setId($user_id);
					$euser->setEvent($event->getId());
					$euser->setRule("e_partner");
					$euser->setFile(new \Application\Model\File());

					$finder_euser->insert($euser);

					$manager->delUser($group_users_id, $user_id);
					$manager->addUser($group_partners_id, $user_id, "nmg_partner");
					break;

				case 'invit':
					$euser = new \Application\Model\EUser();

					$euser->setId($user_id);
					$euser->setEvent($event->getId());
					$euser->setRule("e_partner");
					$euser->setFile(new \Application\Model\File());

					$finder_euser->insert($euser);

					$manager->addUser($group_all_id, $user_id, "nmg_partner");
					$manager->addUser($group_partners_id, $user_id, "nmg_partner");
					break;
			}
		}

		return $this->redirect($this->req["redirect"]);
	}
}
