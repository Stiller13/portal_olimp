<?php

namespace Application\Command;

class EventCreate extends \System\Core\Command {

	public function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		if ($this->req["title"] === "") {
			return $this->render(array("user" => $user, "message" => "Не заполнено название мероприятия", "type_message" => "alert-danger"), "EventCreateShow");
		}

		$new_cmg = new \Application\Model\CommentMessageGroup();

		$new_cmg->setStatus("open");
		$new_cmg->setDescription("Комментарии");
		// $new_cmg->setId(11);
		$factory_group = \System\Orm\PersistenceFactory::getFactory("CommentMessageGroup");
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_cmg);

		$new_nmg1 = new \Application\Model\NoticeMessageGroup();

		$new_nmg1->setStatus("partners");
		$new_nmg1->setDescription("Для участников");
		// $new_nmg1->setId(12);
		$factory_group = \System\Orm\PersistenceFactory::getFactory("NoticeMessageGroup");
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_nmg1);

		$new_nmg2 = new \Application\Model\NoticeMessageGroup();

		$new_nmg2->setStatus("users");
		$new_nmg2->setDescription("Для заявителей");
		// $new_nmg2->setId(13);
		$group_finder->insert($new_nmg2);

		$new_nmg3 = new \Application\Model\NoticeMessageGroup();

		$new_nmg3->setStatus("all");
		$new_nmg3->setDescription("Для всех");
		// $new_nmg3->setId(14);
		$group_finder->insert($new_nmg3);

		$list_noticegroup = new \Application\Orm\NoticeMessageGroupCollection();
		$list_noticegroup->add($new_nmg1);
		$list_noticegroup->add($new_nmg2);
		$list_noticegroup->add($new_nmg3);

		$upload = new \Application\Orm\FileCollection();


		$event = new \Application\Model\Event();
		$event->setTitle($this->req["title"]);
		$event->setDescription_public("");
		$event->setDescription_private("");
		$event->setEvent_type("private");
		$event->setConfirm(0);
		$event->setConfirm_description("");
		$event->setComments($new_cmg);
		$event->setNoticeGroups($list_noticegroup);
		$event->setFiles($upload);
		$event->setStatus("create");

		$factory = \System\Orm\PersistenceFactory::getFactory("Event");
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$finder->insert($event);

		if ($event->getId() > 0) {
			$factory_euser = \System\Orm\PersistenceFactory::getFactory("EUser");
			$finder_euser = new \System\Orm\DomainObjectAssembler($factory_euser);

			$euser = new \Application\Model\EUser();

			$euser->setId($user->getId());
			$euser->setEvent($event->getId());
			$euser->setRule("e_admin");
			$euser->setFile(new \Application\Model\File());

			$finder_euser->insert($euser);

			return $this->redirect("/event/".$event->getId()."/change");
		} else {
			return $this->redirect("/event");
		}
	}
}

