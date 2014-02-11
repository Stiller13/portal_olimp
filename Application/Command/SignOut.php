<?php

namespace Application\Command;

class SignOut extends \System\Core\Command{

	protected function exec(){
		$login = \System\Auth\Login::instance();
		$login->SignOut();

		return $this->redirect("/");
	}
}

?>
