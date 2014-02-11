<?php
namespace Application\Model;
/**
 * абстрактный класс- документ (статья или тезис или презентация)
 * @author Симонова Ю.
 * @todo Будет апгрейдится)
 * @package files
 */
abstract class Document extends \System\Orm\DomainObject{
    private $authors; 
    private $title;    
	private $content;
    abstract function getDocument();
    /**
     * задаем список авторов
     * @param $Authors Список авторов
     */
    function setAuthors(Application\Orm\AuthorCollection $authors){
        $this->authors= $authors;        
    }
    /**
     * выдаем список авторов
     */    
    function getAuthors(){   
        if (! isset($this->authors)){
            $this->authors= $this->getCollection($this->targetClass(),$this->getId());
        }
        return $this->authors;
    }
    
    function addAuthor(Author $author){
        $this->getAuthors()->add($author);
    }
    /**
     * задаем заголовок
     * @param $title заголвок
     */    
    function setTitle($title){  
        $this->title= $title;
    }
    /**
     * выдаем заголовок документа
     * @return string
     */    
    function getTitle(){  
        return $this->title;
    }
    /**
     * задаем заголовок
     * @param $title заголвок
     */    
    function setContent($content){  
        $this->content= $content;
    }
    /**
     * выдаем заголовок документа
     * @return string
     */    
    function getContent(){  
        return $this->content;
    }
}
?>