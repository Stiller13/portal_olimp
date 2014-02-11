<?php

namespace System\Msg;

use Exception;
/**
 * @author Zalutskii
 * @version 10.02.14
 * Фабрика менеджеров групп сообщений
 */

class FactoryMGManager {

	//Как в БД
	const PERSONAL_GROUP = 1;
	const COMMENT_GROUP = 2;
	const SYSTEM_GROUP = 3;

	static $types = array(
		'personal' => self::PERSONAL_GROUP,
		'comment' => self::COMMENT_GROUP,
		'system' => self::SYSTEM_GROUP);

	static $managers = array(
		'personal' => 'PersonalMGManager',
		'comment' => 'CommentMGManager',
		'system' => 'SystemMGManager');

	static $classes = array(
		'personal' => 'PersonalMessageGroup',
		'comment' => 'CommentMessageGroup',
		'system' => 'SystemMessageGroup');

	static $roles = array(
		'personal' => array(
			'admin' => 1,
			'partner' => 2),

		'comment' => array(),

		'system' => array(
			'partner' => 15));

	public static function getManager($type) {
		$class = '\System\Msg\\'.self::$managers[$type];

		return new $class(self::$types[$type], self::$classes[$type], self::$roles[$type]);
	}

}

?>