<?php
namespace System\Auth;

use System\Auth\Group;
use System\Auth\GroupMap;


class Rule extends Group{

	public function getParent(){
		$g_map = GroupMap::instance();
		return $g_map->getRule($this->parent);
	}
}



?>
