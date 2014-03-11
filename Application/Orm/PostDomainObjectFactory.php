<?php

namespace Application\Orm;

class PostDomainObjectFactory extends \System\Orm\DomainObjectFactory{

	public function doCreateObject(array $array) {
		$obj= new \Application\Model\Post();

		$obj->setId($array["post_id"]);
		$obj->setTitle($array["post_title"]);
		$obj->setText($array["post_text"]);
		$obj->setDate($array["post_date"]);
		$obj->setComments($this->createComments($array["post_comment_mg"]));
		$obj->setStatus(\System\Helper\Helper::getName("status", $array["post_status"]));
		$obj->setPost_type(\System\Helper\Helper::getName("type", $array["post_type"]));

		return $obj;
	}

	private function createComments($id_mg) {
		$factory = \System\Orm\PersistenceFactory::getFactory("CommentMessageGroup");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("messagegroup_id")->eq($id_mg);
		$idobj->field("messagegroup_type")->eq(\System\Helper\Helper::getId("type", "comment"));

		return $finder->findOne($idobj, "messagegroup");
	}

	public  function targetClass(){
		return "Post";
	}
}
?>
