<?php

namespace Application\Model;

/**
 * @author Zalutskii
 * @version 18.02.14
 * Класс системных оповещений
 */

class SystemMessageGroup extends \Application\Model\PersonalMessageGroup {

	public function targetClass() {
		return 'SystemMessageGroup';
	}
}

?>