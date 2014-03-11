<?php

namespace Application\Command;

class NewsChangeShow extends \System\Core\Command{

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');

		$factory =\System\Orm\ PersistenceFactory::getFactory("Post");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("post_id")->eq($this->data["news_id"]);

		$news = $finder->findOne($idobj, "post");

		return $this->render(array("user" => $user, "news" => $news));
	}
}