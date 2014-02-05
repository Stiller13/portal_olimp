<?php

namespace Application\Command;

class MainPageShow extends \System\Core\Command {
	protected function exec(){
		return $this->render();
	}
}