<?php

namespace Application\Command;

class NewsRatioChange extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory = \System\Orm\PersistenceFactory::getFactory("PUser");
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$euser = new \Application\Model\PUser();

		$euser->setId($user->getId());
		$euser->setPost($this->data["news_id"]);
		$euser->setRule("p_user");

		if ($this->req["do_ratio"] == $this->req["ratio"])
			$this->req["do_ratio"] = "middle";

		$euser->setRatio($this->req["do_ratio"]);

		$finder->insert($euser);

		return $this->redirect("/news/".$this->data["news_id"]);
	}
}
