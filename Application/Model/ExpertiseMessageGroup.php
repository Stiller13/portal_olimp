<?php

namespace Application\Model;

/**
 * @author Zalutskii
 * @version 25.12.13
 * Класс комментариев
 */

class ExpertiseMessageGroup extends \Application\Model\PersonalMessageGroup {

	private $document;

	public function setDocument($doc){
		$this->document = $doc;
		$this->markDirty();
	}

	public function getDocument() {
		return $this->document;
	}

	public function getTypeId() {
		return \System\Msg\FactoryMGManager::EXPERTISE_GROUP;
	}

	public function targetClass() {
		return 'ExpertiseMessageGroup';
	}
}

?>