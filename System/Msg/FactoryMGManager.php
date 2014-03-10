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
		'system' => 'SystemMGManager',
		'notice' => 'NoticeMGManager');

	static $classes = array(
		'personal' => 'PersonalMessageGroup',
		'comment' => 'CommentMessageGroup',
		'system' => 'SystemMessageGroup',
		'notice' => 'NoticeMessageGroup');

	public static function getManager($type) {
		$class = '\System\Msg\\'.self::$managers[$type];
		$type_id = \System\Helper\Helper::getid("type", $type);

		return new $class($type_id, self::$classes[$type]);
	}

}

?>