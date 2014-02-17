<?php

namespace System\File;

/**
* Класс для работы с файлами
* @author Zalutskii
* @version 22.01.14
* @todo Добавить методы на создание и пр. файлов
*/

class FileManager {

	const UPLOAD_STAT_OK = 0;
	const UPLOAD_STAT_COPY = 1;
	const UPLOAD_STAT_DMKD = 2;

	public static function getError($num) {
		switch($num) {
			case UPLOAD_ERR_OK : return 'Ошибок не возникло, файл был успешно загружен на сервер.'; break;
			case UPLOAD_ERR_INI_SIZE : return 'Размер принятого файла превысил максимально допустимый размер'; break;
			case UPLOAD_ERR_FORM_SIZE : return 'Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме.'; break;
			case UPLOAD_ERR_PARTIAL : return 'Загружаемый файл был получен только частично.'; break;
			case UPLOAD_ERR_NO_FILE : return 'Файл не был загружен.'; break;
			case UPLOAD_ERR_NO_TMP_DIR : return 'Отсутствует временная папка.'; break;
			case UPLOAD_ERR_CANT_WRITE : return 'Не удалось записать файл на диск.'; break;
			case UPLOAD_ERR_EXTENSION : return 'PHP-расширение остановило загрузку файла. PHP не предоставляет способа определить какое расширение остановило загрузку файла.'; break;
		}
	}

	public static function getStatus() {}
	public static function get_dir($date = null) {
		if (!$date)
			return date("Y.n");
		$array_date = date_parse($date);
		return $array_date["year"].".".$array_date["month"];
	}

	/**
	 * Запись информации о файлах в БДS
	 * @return \Application\Orm\FileCollection
	 */
	public function upload_files(){
		$files = new \Application\Orm\FileCollection();

		foreach (self::upload() as $one_upload) {
			if ($one_upload['status'] == 0) {
				$new_file = new \Application\Model\File();
				$new_file->setName($one_upload['name']);
				$new_file->setCode($one_upload['code']);

				$file_factory = \System\Orm\PersistenceFactory::getFactory('File');
				$file_finder = new \System\Orm\DomainObjectAssembler($file_factory);
				$file_finder->insert($new_file);

				$files->add($new_file);
			}
		}

		return $files;
	}

	/**
	* Загрузка файла на сервер
	* @todo Запилить ограничения по размеру, по расширению
	* @return array()
	*/
	public static function upload() {
		$status_result = array();

		if(isset($_FILES['uploadfiles'])) {
			$file_count = count($_FILES["uploadfiles"]['name']);

			for ($i = 0; $i<$file_count; $i++) {
				$status_result[$i]['name'] = $_FILES['uploadfiles']['name'][$i];
				$status_result[$i]['size'] = $_FILES['uploadfiles']['size'][$i];
				$status_result[$i]['type'] = $_FILES['uploadfiles']['type'][$i];
				$status_result[$i]['error'] = $_FILES['uploadfiles']['error'][$i];
				// $status_result[$i]['status'] = '';

				if ($_FILES['uploadfiles']['error'][$i] === UPLOAD_ERR_OK) {
					if(is_uploaded_file($_FILES['uploadfiles']['tmp_name'][$i])) {

						$status_result[$i]['code'] = md5(md5_file($_FILES['uploadfiles']['tmp_name'][$i]).date('YmdHis'));
						$uploadfile = UPL.DS.self::get_dir();

						if(!is_dir($uploadfile))
							if (!mkdir($uploadfile)) {
								$status_result[$i]['status'] = UPLOAD_STAT_DMKD;
								continue;
							}
						$uploadfile .= DS.$status_result[$i]['code'];

						if (copy($_FILES['uploadfiles']["tmp_name"][$i], $uploadfile))
							$status_result[$i]['status'] = UPLOAD_STAT_OK;
						else
							$status_result[$i]['status'] = UPLOAD_STAT_COPY;
					}
				}
			}
		}

		return $status_result;
	}

	public static function download_file($file_code){
		$file_factory = \System\Orm\PersistenceFactory::getFactory('File');
		$file_finder = new \System\Orm\DomainObjectAssembler($file_factory);
		$idobj = $file_factory->getIndentityObject();

		$idobj->field('file_code')->eq($file_code);

		$file = $file_finder->findOne($idobj, 'file');

		$file_dir = DS.self::get_dir($file->getDate());

		$file_path = UPL.$file_dir.DS.$file_code;
		self::download($file_path, $file->getName());
	}

	/**
	* Отдача файла с сервера
	*/
	public static function download($file_path, $file_outname = "", $mimetype = "application/octet-stream") {
		if(!file_exists($file_path)) {
			xlog("file not found");
		} else {
			if (!$file_outname) {
				$file_outname = basename($file_path);
			}
			$fsize = filesize($file_path);
			$ftime = date("D, d M Y H:i:s T", filemtime($file_path));
			$fd = @fopen($file_path, "rb");
			if (!$fd){
				header ("HTTP/1.0 403 Forbidden");
				exit;
			}

			if($HTTP_SERVER_VARS["HTTP_RANGE"]) {
				$range = $HTTP_SERVER_VARS["HTTP_RANGE"];
				$range = str_replace("bytes=", "", $range);
				$range = str_replace("-", "", $range);
				if ($range)
					fseek($fd, $range);
			}

			if($range) {
				header("HTTP/1.1 206 Partial Content");
			} else {
				header("HTTP/1.1 200 OK");
			}
			header("Content-Disposition: attachment; filename=$file_outname");
			header("Last-Modified: $ftime");
			header("Accept-Ranges: bytes");
			header("Content-Length: ".($fsize-$range));
			header("Content-Range: bytes $range-".($fsize - 1)."/".$fsize);
			header("Content-type: $mimetype");

			fpassthru($fd);
			exit; 
		}
	}
}