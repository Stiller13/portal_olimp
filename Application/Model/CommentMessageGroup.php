<?php

namespace Application\Model;

/**
 * @author Zalutskii
 * @version 25.12.13
 * Класс комментариев
 */

class CommentMessageGroup extends \Application\Model\PersonalMessageGroup {

	public function targetClass() {
		return 'CommentMessageGroup';
	}
}

?>