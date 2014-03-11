<?php

namespace Application\Command;

class NewsShowAll extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user"); 

		$page = $this->data["page"]?$this->data["page"]:1;
		$count_news_on_page = 30;

		$factory = \System\Orm\PersistenceFactory::getFactory("Post");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("post_status")->eq(\System\Helper\Helper::getId("status", "open"));
		$idobj->addOrder(array("post_date"=>"DESC"));

		$idobj->addLimit(array("0" => $count_news_on_page*($page - 1), "1" => $count_news_on_page));

		$news = $finder->find($idobj, "post");

		$factory = \System\Orm\PersistenceFactory::getFactory("UserRole");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("role_user")->eq($user->getId());
		$idobj->field("role_role")->eq(\System\Helper\Helper::getId("role", "MODERATOR"));

		$user_role = $finder->findOne($idobj,"role");
		if ($user_role) {
			$can_create = 1;
		}

		return $this->render(array("user" => $user, "news" => $news, "can_create" => $can_create, "page" => $page));
	}
}
