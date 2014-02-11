<?php

namespace Application\Command;

use System\Session\Session;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;
use System\Orm\IdentityObject;
use System\Auth\Crypter;

class MyAccountSave extends \System\Core\Command{

	protected function exec() {
		$session = new Session();
		$user = $session->get("user");

		$factory = PersistenceFactory::getFactory('Account');
		$finder = new DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();
		$idobj->field('account_id')->eq($user->getId());
		$acc = $finder->findOne($idobj, 'account');

		$type_message = "alert-danger";

		if ($acc->getPass() == Crypter::genPass($this->req["old_pass"], $acc->getSalt())){
			$pattern = '/^[a-zA-Z][a-zA-Z0-9\-\_]{2,9}+$/';

			$pass1 = $this->req["new_pass1"];
			$pass2 = $this->req["new_pass2"];

			preg_match($pattern,$pass1,$found);

			if ($found){
				if ($pass1 === $pass2){

					$salt = Crypter::genSalt();
					$pass = Crypter::genPass($pass1, $salt);
					$acc->setSalt($salt);
					$acc->setPass($pass);
					xlog("acc  ".$acc->getPass().'  '.$acc->getSalt().' '.$acc->getId());	

					$factory = \System\Orm\PersistenceFactory::getFactory('Account');
					$finder = new \System\Orm\DomainObjectAssembler($factory);
					$finder->insert($acc);

					$finder->insert($acc);

					$mess = "OK";
					$type_message = "alert-success";
				}
				else {
					$mess = "Passwords are not equal";
				}
			}
			else {
				$mess = "Regexp password";
			}
		}
		else {
			$mess = "It's not your password. DENIED.";
		}
		xlog("mess".$mess);
		return $this->render(array("user" => $user, "message" => $mess, "type_message" => $type_message), "MyAccountShow");
	}
}
