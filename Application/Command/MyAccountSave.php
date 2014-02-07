<?php

namespace Application\Command;

class MyAccountSave extends \System\Core\Command{
	public function exec() {

		return $this->redirect("/cabinet/account");
	}
}
