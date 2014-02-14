<?php
namespace Application\Command;

/**
* Так как класс Command, от которого нужно наследоваться,
* находится в "/System/Core/Command.php" то обращаемся к 
* нему через полное имя \System\Core\Command.
* (слэш впереди нужен, так как мы сейчас в пространстве Application\Command
* и, если мы его уберем, система начнёт искать класс Command в Application\Command\System\Core\Command)
**/
class DefaultCommand extends \System\Core\Command {
	protected function exec(){
		//\System\Log\Logger::log("default is here!");
		//return array("forward"=>"StockCommand");
		// return array("redirect"=> "dokaku");
		//echo $this->generateURL("profile_ex", array("uid"=>"12", "extra"=>"world"));
		return $this->render();
	}
}