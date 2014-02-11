<?php
namespace System\Auth;
use PDO;
use System\Auth\Crypter;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;
use Application\Model\User;
use Application\Model\Account;

/**
 * Класс регистрации пользователей 
 * 
 * @package 
 * @version 0.5
 * @copyright bsu-web
 * @author Derjugin 
 * @license IDK (I Dont Know)
 */
class Registration {

	/**
	 * Регистрация нового пользователя в системе 
	 * 
	 * @param mixed $user 
	 * @param mixed $pass1 
	 * @param mixed $pass2 
	 * @access public
	 * @return void
	 */
	public function register($user, $pass1, $pass2){
		
		$factory= PersistenceFactory::getFactory('Account');
		$finder= new DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();
		$idobj->field('authorization_login')->eq($user);
		$acc = $finder->findOne($idobj,'authorization');

		$pattern = '/^[a-zA-Z][a-zA-Z0-9\-\_]{2,9}+$/';

		preg_match($pattern,$user,$found);
		if (!$found){
			return "Regexp login";
		}
		preg_match($pattern,$pass1,$found);
		if (!$found){
			return "Regexp password";
		}
		if ($acc) {
			return "Login is already taken";	
		}

		if ($pass1 === $pass2){
			$salt = Crypter::genSalt();
			$pass = Crypter::genPass($pass1, $salt);
			$acc = new Account();
			$acc->setPass($pass);
			$acc->setSalt($salt);
			$acc->setLogin($user);

			$finder->insert($acc);

			$factory= PersistenceFactory::getFactory('User');
			$finder= new DomainObjectAssembler($factory);
			$idobj=$factory->getIndentityObject();
			$idobj->field('user_id')->eq($acc->getId());
			$user = $finder->findOne($idobj,'user');


			/*$user = new User();
			$factory= PersistenceFactory::getFactory('User');
			$finder= new DomainObjectAssembler($factory);
			$idobj=$factory->getIndentityObject();
			$finder->insert();
			$user = $finder->findOne($idobj,'user');
			 */
			return "Registration Complete";
		}
		else {
			return "Passwords are not equal";
		}



	}

}

?>
