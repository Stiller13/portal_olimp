<?php

namespace Application\Model;

class PUser extends \Application\Model\User{

	private $rule;

	private $ratio = 0;

	private $post;

	public function setRule($rule) {
		$this->rule = $rule;
		$this->markDirty();
	}

	public function getRule() {
		return $this->rule;
	}

	public function setRatio($ratio) { 
		$this->ratio = $ratio;
		$this->markDirty();
	}

	public function getRatio() {
		return $this->ratio;
	}

	public function setPost($post) {
		$this->post = $post;
		$this->markDirty();
	}

	public function getPost() {
		return $this->post;
	}

	public function targetClass() {
		return 'PUser';
	}
}
?>