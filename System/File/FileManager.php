<?php

namespace System\File;

/**
* Класс для работы с файлами
* @author Zalutskii
* @version 22.01.14
* @todo Добавить методы на создание и пр. файлов
*/

class FileManager {

	public static function get_dir($date = null) {
		if (!$date)
			return date("Y.n");
		$array_date = date_parse($date);
		return $array_date["year"].".".$array_date["month"];
	}

	/**
	 * Запись информации о файлах в БД
	 * @return \Application\Orm\FileCollection
	 */
	public static function upload_files() {
		$files = new \Application\Orm\FileCollection();

		$dir = UPL.self::get_dir();
		$file_factory = \System\Orm\PersistenceFactory::getFactory("File");
		$file_finder = new \System\Orm\DomainObjectAssembler($file_factory);

		foreach (Uploader::upload($dir) as $one_upload) {
			if ($one_upload["status"] === Uploader::UPLOAD_STAT_OK) {
				$new_file = new \Application\Model\File();
				$new_file->setName($one_upload["name"]);
				$new_file->setCode($one_upload["code"]);
				$new_file->setFile_type("default");
				$new_file->setStatus("default");

				$file_finder->insert($new_file);

				$files->add($new_file);
			}
		}

		return $files;
	}

	public static function download_file($file_code) {
		$file_factory = \System\Orm\PersistenceFactory::getFactory("File");
		$file_finder = new \System\Orm\DomainObjectAssembler($file_factory);
		$idobj = $file_factory->getIndentityObject();

		$idobj->field("file_code")->eq($file_code);

		$file = $file_finder->findOne($idobj, "file");

		$file_dir = DS.self::get_dir($file->getDate());

		$file_path = UPL.$file_dir.DS.$file_code;

		return array("path" => $file_path, "name" => $file->getName());
		// self::download($file_path, $file->getName());
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