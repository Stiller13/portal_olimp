<?php

namespace Application\Model;

/**
 * Класс файла
 * @author Zalutskii
 * @version 30.10.13
 */

class File extends \System\Orm\DomainObject {
    /**
    * Название файла
    */
    private $name;

    /**
    * Уникальный код файла
    */
    private $code;

    /**
     * Дата загрузки файла
     * @var date
     */
    private $date;

    /**
    * Задать имя файла
    */
    public function setName($name) {
        $this->name = $name;
        $this->markDirty();
    }

    /**
    * Полуить имя файла
    */
    public function getName() {
        return $this->name;
    }

    /**
    * Задать код файла
    */
    public function setCode($code) {
        $this->code = $code;
        $this->markDirty();
    }

    /**
    * Полуить код файла
    */
    public function getCode() {
        return $this->code;
    }

    /**
     * Установить дату
     * @param date $new_date
     */
    public function setDate($date) {
        $this->date = $date;
        $this->markDirty();
    }

    /**
     * Получить дату загрузки файла
     * @return date
     */
    public function getDate() {
        return $this->date;
    }

    public function targetClass() {
        return 'File';
    }
}

?>