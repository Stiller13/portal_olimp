<?php

namespace Application\Command;

class NewsShow extends \System\Core\Command {

	protected function exec() {
		$factory = \System\Orm\PersistenceFactory::getFactory("Post");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("post_id")->eq($this->data["news_id"]);

		$news = $finder->findOne($idobj, "post");


		$session = new \System\Session\Session();
		$user = $session->get("user"); 

		if ($user) {
			$factory = \System\Orm\PersistenceFactory::getFactory("RuleObj");
			$finder = new \System\Orm\DomainObjectAssembler($factory);
			$idobj = $factory->getIndentityObject();

			$idobj->field("user_id")->eq($user->getId());
			$idobj->field("obj_type")->eq(\System\Helper\Helper::getId("type", "post"));
			$idobj->field("obj_id")->eq($this->data["news_id"]);

			$rule = $finder->findOne($idobj, "rule");
			if ($rule) {
				$rule = $rule->getRule();
			}
		}

		return $this->render(array("user" => $user, "news" => $news, "rule" => $rule));
	}
}
