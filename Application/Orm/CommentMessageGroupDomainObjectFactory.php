<?php

namespace Application\Orm;

class CommentMessageGroupDomainObjectFactory extends \System\Orm\DomainObjectFactory {

    public function doCreateObject(array $array) {
        $obj = new \Application\Model\CommentMessageGroup();

        $obj->setId($array['message_group_id']);
        $obj->setTitle($array['message_group_title']);
        $obj->setDescription($array['message_group_description']);
        $obj->setStatus($array['message_group_status']);
        $obj->setMessages($this->createMessages($obj->getId()));
        $obj->setPartners(new \Application\Orm\UserCollection());

        return $obj;
    }

    public function createMessages($group_id) {
        $factory = \System\Orm\PersistenceFactory::getFactory('Message');
        $finder = new \System\Orm\DomainObjectAssembler($factory);
        $idobj = $factory->getIndentityObject();
        $idobj->field('messageset_id')->eq($group_id);

        return $finder->find($idobj, 'message');
    }

    public  function targetClass() {
        return "CommentMessageGroup";
    }
}

?>