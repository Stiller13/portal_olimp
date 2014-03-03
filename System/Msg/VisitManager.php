<?php

namespace System\Msg;

/**
 * @author Zalutskii
 * @version 1.0
 * Класс-менеджер посещения групп, отслеживания количества новых сообщений
 */

class VisitManager {

	public static function getCountMess($param) {
		$factory = \System\Orm\PersistenceFactory::getFactory('Visit');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('user_id')->eq($param["user_id"]);

		switch ($param["for"]) {
			case "group":
				$idobj->field('group_id')->eq($param["group_id"]);
				$table_name = "visit1";
				break;

			case "type_group":
				$idobj->field('type')->eq($param["group_type_id"]);
				$table_name = "visit2";
				break;

			case "all":
				$table_name = "visit3";
				break;

			default:
				# code...
				break;
		}
		$visit = $finder->findOne($idobj, $table_name);

		if ($visit) {
			return $visit->getCountMessage();
		} else {
			return 0;
		}
	}

	public static function updateVisit($param) {
		$factory = \System\Orm\PersistenceFactory::getFactory('Visit');
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$visit = new \Application\Model\Visit();

		$visit->setUserId($param["user_id"]);
		$visit->setMessageGroupId($param["group_id"]);

		$finder->insert($visit);
	}

}

?>