<?php

namespace Application\Command;

class NewsShow extends \System\Core\Command {

	protected function exec() {
		$factory = \System\Orm\PersistenceFactory::getFactory("Post");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("post_id")->eq($this->data["news_id"]);

		$news = $finder->findOne($idobj, "post_wratio");


		$session = new \System\Session\Session();
		$user = $session->get("user");

		if ($user) {
			$factory = \System\Orm\PersistenceFactory::getFactory("PUser");
			$finder = new \System\Orm\DomainObjectAssembler($factory);
			$idobj = $factory->getIndentityObject();

			$idobj->field("post_user_user")->eq($user->getId());
			// $idobj->field("obj_type")->eq(\System\Helper\Helper::getId("type", "post"));
			$idobj->field("post_user_post")->eq($news->getId());

			$rule = $finder->findOne($idobj, "post_user");
			if ($rule) {
				$ratio = $rule->getRatio();
				$rule = $rule->getRule();
			} else {
				$ratio = 0;
			}
		}

		return $this->render(array("user" => $user, "news" => $news, "rule" => $rule, "ratio" => $ratio));
	}
}
