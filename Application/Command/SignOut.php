<?php

namespace Application\Command;

use System\Auth\Login;
/**
 *
 * @author user
 *        
 */
class SignOut extends \System\Core\Command{
	public function exec(){
		$login = Login::instance();
		$login->SignOut();
		return $this->forward("DefaultCommand", '');
	}
}

?>
