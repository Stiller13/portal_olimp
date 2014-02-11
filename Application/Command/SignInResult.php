<?php
namespace Application\Command;


use System\Session\Session;
use System\Auth\Login;
use System\Auth\DefaultGate;


class SignInResult extends \System\Core\Command{
	public function exec(){
		//$gate = new DefaultGate(); 
		$auth = Login::instance();
		$result = $auth->SignIn($this->req["login"], $this->req["pass"]);

		return $this->render(
			array("result" => $result));
	}
}
