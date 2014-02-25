<?php

namespace System\Msg;

/**
 * @author Zalutskii
 * @version 24.12.13
 * Класс-менеджер группы коментариев
 */

class CommentMGManager extends \System\Msg\MessageGroupManager {

	/**
	 * Отправить сообщение
	 */
	public function SendMessage($data) {
		$author = new \Application\Model\User();
		$author->setId($data['user_id']);

		$upload = \System\File\FileManager::upload_files();
		if (is_null($upload))
			$upload = new \Application\Orm\FileCollection();

		$new_message = new \Application\Model\Message();
		$new_message->setText($data['text']);
		$new_message->setAuthor($author);
		$new_message->setReMessage($data['id_remessage']);
		$new_message->setStatus($data['status']);
		$new_message->setGroup($data['group_id']);
		$new_message->setStatus($data['status']);

		$new_message->setFiles($upload);

		// Производим вставку
		$message_factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$message_finder = new \System\Orm\DomainObjectAssembler($message_factory);
		$message_finder->insert($new_message);
	}
}
?>