<?php
namespace System\Access;

abstract class AccessManager {
	abstract public function addGroup();
	abstract public function addUserToGroup();
	abstract public function check();
}