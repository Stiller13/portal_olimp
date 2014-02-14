<?php

namespace Application\Command;

class MSPersonalGroupDelMe extends \System\Core\Command {

	protected function exec() {

		if ($this->req['secret_param'] === 's_e_cret_122') {
			$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
			$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
			$ruleobj_idobj = $factory_ruleobj->getIndentityObject();

			$ruleobj_idobj->field('obj_id')->eq($this->req['group_id']);
			$ruleobj_idobj->field('obj_type')->eq(1);

			$rule = $ruleobj_finder->findOne($ruleobj_idobj, 'rule');


			$ruleobj_idobj = $factory_ruleobj->getIndentityObject();
			$ruleobj_idobj->field('user_userset_user_id')->eq($this->req['user_id']);
			$ruleobj_idobj->field('user_userset_userset_id')->eq($rule->getUserset_id());

			$ruleobj_finder->delete($ruleobj_idobj, 'user_userset');


			$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
			$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);
			$visit_idobj = $factory_visit->getIndentityObject();

			$visit_idobj->field('user_mg_read_user')->eq($this->req['user_id']);
			$visit_idobj->field('user_mg_read_mg')->eq($this->req['group_id']);

			$visit_finder->delete($visit_idobj, 'user_mg_read');

		}

		return $this->redirect("/cabinet/message/personal");
	}

}