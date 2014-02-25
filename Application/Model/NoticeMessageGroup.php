<?php

namespace Application\Model;

/**
 * @author Zalutskii
 * @version 25.02.13
 * Класс оповещений
 */

class NoticeMessageGroup extends \System\Msg\MessageGroup {

	public function targetClass() {
		return 'NoticeMessageGroup';
	}
}

?>