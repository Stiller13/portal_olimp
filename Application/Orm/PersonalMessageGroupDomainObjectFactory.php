<?php

namespace Application\Orm;

class PersonalMessageGroupDomainObjectFactory extends \System\Orm\DomainObjectFactory {

    public function doCreateObject(array $array) {
        $obj = new \Application\Model\PersonalMessageGroup();

        $obj->setId($array['message_group_id']);
        $obj->setTitle($array['message_group_title']);
        $obj->setDescription($array['message_group_description']);
        $obj->setMessages($this->createMessages($obj->getId()));
        $obj->setPartners($this->createCollection("User", "user", "user_userset", "user_id", "user_id", "userset_id", $array['message_group_partners']));

        $visit = $this->createVisit($array['message_group_id']);
        if ($visit) $obj->setVisit($visit);

        return $obj;
    }

    public function createMessages($group_id) {
        $factory = \System\Orm\PersistenceFactory::getFactory('Message');
        $finder = new \System\Orm\DomainObjectAssembler($factory);
        $idobj = $factory->getIndentityObject();
        $idobj->field('messageset_id')->eq($group_id);

        return $finder->find($idobj, 'message');
    }

    public function createVisit($group_id) {
        //Берем текущего пользователя системы
        $session = new \System\Session\Session();
        $user = $session->get('user');

        $factory = \System\Orm\PersistenceFactory::getFactory('Visit');
        $finder = new \System\Orm\DomainObjectAssembler($factory);
        $idobj = $factory->getIndentityObject();

        $idobj->field('visit_message_group_id')->eq($group_id);
        $idobj->field('user_id')->eq($user->getId());

        return $finder->findOne($idobj, 'visit');
    }

    public  function targetClass() {
        return "PersonalMessageGroup";
    }
}

?>