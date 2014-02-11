<?php

namespace Application\Orm;

class MessageCollection extends \System\Orm\Collection {

	public function targetClass() {
		return "Message";
	}
}

?>