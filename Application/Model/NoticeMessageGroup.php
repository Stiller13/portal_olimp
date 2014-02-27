<?php

namespace Application\Model;

/**
 * @author Zalutskii
 * @version 25.02.13
 * Класс оповещений
 */

class NoticeMessageGroup extends \Application\Model\PersonalMessageGroup {

	public function targetClass() {
		return 'NoticeMessageGroup';
	}
}

?>