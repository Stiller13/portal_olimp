<?php

namespace Application\Orm;

class UserUpdateFactory extends \System\Orm\UpdateFactory{
    function newUpdate(DomainObject $obj){
        //???? ???????? ????
        $id= $obj->getId();
        $values['name']=$obj->getName();
        $values['family']=$obj->getFamily();
        $values['patronymic']= $obj->getPatronymic();
        $values['birthday']=$obj->getBirthday();
        $values['resid']=$obj->getResidence();
        $values['gender']=$obj->getGender();
        $values['edu']=$obj->getEducation();
        $values['tags']='1,3';
        if ($id >-1){
            $values['id']=$obj->getId();
            return $this->buildStatement('update_user',$values);
        }
        //return $this->buildStatement('insert_user',$values);
    }
}

?>
