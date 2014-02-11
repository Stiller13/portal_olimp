<?php
namespace Application\Model;

//класс для статьи
class Paper extends Application\Model\Document{
    function getDocument(){
     //clear   
    }
    
    function targetClass(){
        return 'Paper';
    }
}
?>