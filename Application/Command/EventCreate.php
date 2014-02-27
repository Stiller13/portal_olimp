<?php

namespace Application\Command;

class EventCreate extends \System\Core\Command {

	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$new_cmg = new \Application\Model\CommentMessageGroup();

		$new_cmg->setStatus("open");
		$new_cmg->setDescription('Комментарии');
		$factory_group = \System\Orm\PersistenceFactory::getFactory('CommentMessageGroup');
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_cmg);

		$new_nmg1 = new \Application\Model\NoticeMessageGroup();

		$new_nmg1->setStatus("partners");
		$new_nmg1->setDescription('Для участников');
		$factory_group = \System\Orm\PersistenceFactory::getFactory('NoticeMessageGroup');
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_nmg1);

		$new_nmg2 = new \Application\Model\NoticeMessageGroup();

		$new_nmg2->setStatus("users");
		$new_nmg2->setDescription('Для заявителей');
		$group_finder->insert($new_nmg2);

		$new_nmg3 = new \Application\Model\NoticeMessageGroup();

		$new_nmg3->setStatus("all");
		$new_nmg3->setDescription('Для всех');
		$group_finder->insert($new_nmg3);

		$list_noticegroup = new \Application\Orm\NoticeMessageGroupCollection();
		$list_noticegroup->add($new_nmg1);
		$list_noticegroup->add($new_nmg2);
		$list_noticegroup->add($new_nmg3);


		$event = new \Application\Model\Event();

		$event->setTitle($this->req["title"]);
		$event->setDescription_public($this->req["description_public"]);
		$event->setDescription_private($this->req["description_private"]);
		$event->setEvent_type($this->req["event_type"]);
		$event->setConfirm($this->req["confirm"]);
		$event->setConfirm_description($this->req["confirm_description"]);
		$event->setComments($new_cmg);
		$event->setNoticeGroups($list_noticegroup);

		$factory = \System\Orm\PersistenceFactory::getFactory('Event');
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$finder->insert($event);

		if ($event->getId() > 0) {
			$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
			$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);

			$ruleobj = new \Application\Model\RuleObj();

			$ruleobj->setUser_id($user->getId());
			$ruleobj->setObj_id($event->getId());
			$ruleobj->setRule("e_admin");
			$ruleobj->setObj_type("event");

			$ruleobj_finder->insert($ruleobj);

			return $this->redirect("/event/".$event->getId());
		} else {
			return $this->redirect("/event");
		}
	}
}

