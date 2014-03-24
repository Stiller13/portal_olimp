<?php

namespace Application\Orm;

class MessageDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj= new \Application\Model\Message();

		$obj->setId($array['message_id']);
		$obj->setText($array['message_text']);
		$obj->setDate($array['message_date']);
		$obj->setGroup($array['message_group']);
		$obj->setStatus(\System\Helper\Helper::getName("status" , $array['message_status']));
		$obj->setReMessage($array['message_message']);

		$obj->setMessages($this->createMessages($array['message_id']));

		$obj->setFiles($this->createFiles($array['message_id']));

		$obj->setAuthor($this->createAuthor($array['message_user']));

		return $obj;
	}

	public function createAuthor($author_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('User');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('user_id')->eq($author_id);

		return $finder->findOne($idobj, 'user');
	}

	public function createFiles($message_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('File');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->addJoin('INNER',array('file','message_file'),array('file_id','file_id'));
		$idobj->field('message_id')->eq($message_id);

		return $finder->find($idobj,'file');
	}

	public function createMessages($message_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('message_message')->eq($message_id);

		return $finder->find($idobj, 'message');
	}

	public  function targetClass() {
		return "Message";
	}
}

?>