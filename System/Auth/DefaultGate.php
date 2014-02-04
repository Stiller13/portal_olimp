<?php

namespace System\Auth;

use System\Auth\Gate;
use PDO;
use System\Auth\Crypter;
use Application\Model\Account;
use System\Session\Session;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;


class DefaultGate extends Gate{
	
	
	public function __construct(){
	}

	public function SignIn($user, $pass){

		$factory= PersistenceFactory::getFactory('Account');
		$finder= new DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();
		$idobj->field('authorization_login')->eq($user);
		$acc = $finder->findOne($idobj,'authorization');

		
		if (!$acc){
			return "Not Found";
		}
		$passwd = Crypter::genPass($pass, $acc->getSalt());
		if ($acc->getPass() === $passwd){
			$session = new Session();

			$factory= PersistenceFactory::getFactory('User');
			$finder= new DomainObjectAssembler($factory);
			$idobj=$factory->getIndentityObject();
			$idobj->field('user_id')->eq($acc->getId());
			$user = $finder->findOne($idobj,'user');
			//дальше не знаю. Что с группами и где они хранятся (к какому объекту)  - предстоит выяснить

			$session->set('user', $user);
			return "OK";	
		}
		return "DENIED";
	}

	public function SignOut(){
		$session = new Session();
		if($session->get('user')){
			$session->set('user', null);
		}	
	}
}


?>
