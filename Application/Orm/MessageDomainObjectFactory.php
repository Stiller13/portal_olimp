<?php

namespace Application\Orm;

class MessageDomainObjectFactory extends \System\Orm\DomainObjectFactory {

	public function doCreateObject(array $array) {
		$obj= new \Application\Model\Message();

		$obj->setId($array['message_id']);
		$obj->setText($array['message_text']);
		$obj->setDate($array['message_date']);
		$obj->setGroup($array['messageset_id']);

		$obj->setFiles($this->createFiles($array['message_id']));

		$obj->setAuthor($this->createAuthor($array['user_id']));

		return $obj;
	}

	public function createAuthor($author_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory('User');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject()->field('user_id')->eq($author_id);

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

	public  function targetClass() {
		return "Message";
	}
}

?>