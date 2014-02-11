<?php
namespace Application\Command;

class SaveProfile extends \System\Core\Command {
	protected function exec(){
		return $this->forward("ShowProfile", array("uid" => 4815));
	}
}