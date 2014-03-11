<?php

namespace Application\Command;

class NewsCreate extends \System\Core\Command {

	public function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		if ($this->req["title"] === "") {
			return $this->render(array("user" => $user, "message" => "Не задан заголовок новости", "type_message" => "alert-danger"), "NewsCange");
		}

		if ($this->req["text"] === "") {
			return $this->render(array("user" => $user, "message" => "Не задан текст новости", "type_message" => "alert-danger"), "NewsCange");
		}

		$new_cmg = new \Application\Model\CommentMessageGroup();

		$new_cmg->setStatus("open");
		$new_cmg->setDescription("Комментарии для новости");
		// $new_cmg->setId(11);
		$factory_group = \System\Orm\PersistenceFactory::getFactory("CommentMessageGroup");
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_cmg);

		// $upload = new \Application\Orm\FileCollection();

		$news = new \Application\Model\Post();

		$news->setTitle($this->req["title"]);
		$news->setText($this->req["text"]);
		$news->setComments($new_cmg);
		$news->setStatus("open");
		$news->setPost_type("news");

		$factory = \System\Orm\PersistenceFactory::getFactory("Post");
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$finder->insert($news);

		if ($news->getId() > 0) {
			$factory_user = \System\Orm\PersistenceFactory::getFactory("PUser");
			$finder_user = new \System\Orm\DomainObjectAssembler($factory_user);

			$euser = new \Application\Model\PUser();

			$euser->setId($user->getId());
			$euser->setPost($news->getId());
			$euser->setRule("p_admin");

			$finder_user->insert($euser);

			return $this->redirect("/news/".$news->getId());
		} else {
			return $this->redirect("/news");
		}
	}
}

