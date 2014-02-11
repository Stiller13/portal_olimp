<?php

namespace System\Msg;

use Exception;
/**
 * @author Zalutskii
 * @version 23.12.13
 * Фабрика менеджеров групп сообщений
 */

class FactoryMGManager {

	//Как в БД
	const PERSONAL_GROUP = 1;
	const COMMENT_GROUP = 2;
	const EXPERTISE_GROUP = 3;
	const SYSTEM_GROUP = 4;

	static $types = array(
		'personal' => self::PERSONAL_GROUP,
		'comment' => self::COMMENT_GROUP,
		'expertise' => self::EXPERTISE_GROUP,
		'system' => self::SYSTEM_GROUP);

	static $managers = array(
		'personal' => 'PersonalMGManager',
		'comment' => 'CommentMGManager',
		'expertise' => 'ExpertiseMGManager',
		'system' => 'SystemMGManager');

	static $classes = array(
		'personal' => 'PersonalMessageGroup',
		'comment' => 'CommentMessageGroup',
		'expertise' => 'ExpertiseMessageGroup',
		'system' => 'SystemMessageGroup');

	static $roles = array(
		'personal' => array(
			'admin' => 5,
			'partner' => 6),

		'comment' => array(),

		'expertise' => array(
			'expert' => 7,
			'author' => 8),

		'system' => array(
			'partner' => 9));

	public static function getManager($type) {
		$class = '\System\Msg\\'.self::$managers[$type];

		return new $class(self::$types[$type], self::$classes[$type], self::$roles[$type]);
	}

}

?>