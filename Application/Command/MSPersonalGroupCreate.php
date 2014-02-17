<?php

namespace Application\Command;

class MSPersonalGroupCreate extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

/*		$new_mg = new \Application\Model\PersonalMessageGroup();
		$new_mg->setStatus(0);

		$factory_group = \System\Orm\PersistenceFactory::getFactory('PersonalMessageGroup');
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_mg);

//Вставка в группу пользователей
		$ruleobj = new \Application\Model\RuleObj();

		$ruleobj->setUser_id($user->getId());
		$ruleobj->setObj_id($new_mg->getId());
		$ruleobj->setRule(\System\Helper\Helper::getId("rule", "pmg_admin"));
		$ruleobj->setObj_type(\System\Helper\Helper::getId("type", "messagegroup"));

		$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
		$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
		$ruleobj_finder->insert($ruleobj);

//Вставка в visit-ов
		$visit = new \Application\Model\Visit();
		$visit->setMessageGroupId($new_mg->getId());
		$visit->setUserId($user->getId());

		$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
		$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);
		$visit_finder->insert($visit);*/

		if ($this->req["users"]){
			foreach ($this->req["users"] as $one_user_id) {
				$h[] = array(
					'id' => $one_user_id,
					'rule' => 'pmg_partner');
			}
		}

		$h[] = array(
			'id' => $user->getId(),
			'rule' => 'pmg_admin');
		
		$this->req['users'] = $h;

		$manager = \System\Msg\FactoryMGManager::getManager('personal');
		$new_mg_id = $manager->CreateGroup($this->req);

		return $this->redirect("/cabinet/message/personal/".$new_mg_id);
	}
}