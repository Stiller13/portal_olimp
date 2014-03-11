<?php

namespace Application\Model;

/**
 * Класс поста
 * @author Zalutskii
 */

class Post extends \System\Orm\DomainObject{

	/**
	 * Название поста
	 * @var string 
	 */
	private $title;

	/**
	 * Текст поста
	 * @var string
	 */
	private $text;

	/**
	 * Участники
	 * @var Application\Orm\UserCollection
	 */
	private $partners;

	/**
	 * Группа для комментариев
	 * @var Application\Model\CommentMessageGroup
	 */
	private $comment_group;

	/**
	 * Прикрепленные файлы
	 * @var Application\Orm\FileCollection
	 */
	private $files;

	/**
	 * Статутус поста
	 * @var integer
	 */
	private $status;

	/**
	 * Тип поста
	 * @var integer
	 */
	private $type;

	/**
	 * Дата публикации поста
	 * @var timestamp
	 */
	private $date;

	public function setTitle($text) {
		$this->title = $text;
		$this->markDirty();
	}

	public function getTitle() {
		return $this->title;
	}

	public function setText($text) {
		$this->description_public = $text;
		$this->markDirty();
	}

	public function getText() {
		return $this->description_public;
	}

	public function setPartners(\Application\Orm\EUserCollection $partners) {
		$this->partners = $partners;
		$this->markDirty();
	}

	public function getPartners() {
		if (! isset($this->partners)) {
			$this->partners = $this->getCollection($this->targetClass(), $this->getId());
		}
		return $this->partners;
	}

	public function getComments() {
		return $this->comment_group;
	}

	public function setComments($mg) {
		$this->comment_group = $mg;
		$this->markDirty();
	}

	public function setFiles(\Application\Orm\FileCollection $list_file) {
		$this->files = $list_file;
		$this->markDirty();
	}

	public function getFiles() {
		if (!isset($this->files)) {
			$this->files = $this->getCollection($this->targetClass(), $this->getId());
		}

		return $this->files;
	}

	public function addFile(\Application\Model\File $file) {
		$this->files->add($file);
		$this->markDirty();
	}

	public function setStatus($new_status) {
		$this->status = $new_status;
		$this->markDirty();
	}

	public function getStatus() {
		return $this->status;
	}

	public function setPost_type($new_type) {
		$this->type = $new_type;
		$this->markDirty();
	}

	public function getPost_type() {
		return $this->type;
	}

	public function setDate($new_date) {
		$this->date = $new_date;
		$this->markDirty();
	}

	public function getDate() {
		return $this->date;
	}

	public function targetClass() {
		return 'Post';
	}
}