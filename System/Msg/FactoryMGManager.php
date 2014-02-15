<?php

namespace System\Msg;

use Exception;
/**
 * @author Zalutskii
 * @version 10.02.14
 * Фабрика менеджеров групп сообщений
 */

class FactoryMGManager {

	static $managers = array(
		'personal' => 'PersonalMGManager',
		'comment' => 'CommentMGManager',
		'system' => 'SystemMGManager');

	static $classes = array(
		'personal' => 'PersonalMessageGroup',
		'comment' => 'CommentMessageGroup',
		'system' => 'SystemMessageGroup');

	public static function getManager($type) {
		$class = '\System\Msg\\'.self::$managers[$type];
		$type_id = \System\Helper\Helper::getid("typegroup", $type);

		return new $class($type_id, self::$classes[$type]);
	}

}

?>