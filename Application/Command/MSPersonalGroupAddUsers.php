<?php

namespace Application\Command;

class MSPersonalGroupAddUsers extends \System\Core\Command {

	protected function exec() {

		if ($this->req['secret_param'] === 'top_s_e_cret') {
			$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
			$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);

			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);

			foreach ($this->req['users'] as $id_user) {
				$ruleobj = new \Application\Model\RuleObj();
				$ruleobj->setUser_id($id_user);
				$ruleobj->setObj_id($this->req['group_id']);
				$ruleobj->setRule(\System\Helper\Helper::getId("rule", "pmg_user"));
				$ruleobj->setObj_type(\System\Helper\Helper::getId("type", "messagegroup"));

				$ruleobj_finder->insert($ruleobj);

				$visit = new \Application\Model\Visit();
				$visit->setMessageGroupId($this->req['group_id']);
				$visit->setUserId($id_user);

				$visit_finder->insert($visit);
			}
		}

		return $this->redirect("/cabinet/message/personal/".$this->req['group_id']);
	}

}