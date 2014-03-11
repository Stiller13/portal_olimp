<?php

namespace Application\Command;

class NewsSave extends \System\Core\Command {

	public function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		if ($this->req["title"] === "") {
			return $this->render(array("user" => $user, "message" => "Не задан заголовок новости", "type_message" => "alert-danger"), "NewsCange");
		}

		if ($this->req["text"] === "") {
			return $this->render(array("user" => $user, "message" => "Не задан текст новости", "type_message" => "alert-danger"), "NewsCange");
		}

		$factory =\System\Orm\ PersistenceFactory::getFactory("Post");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("post_id")->eq($this->data["news_id"]);

		$news = $finder->findOne($idobj, "post");

		$news->setTitle($this->req["title"]);
		$news->setText($this->req["text"]);

		$finder->insert($news);

		return $this->redirect("/news/".$news->getId());
	}
}

