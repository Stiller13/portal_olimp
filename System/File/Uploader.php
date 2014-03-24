<?php

namespace System\File;

class Uploader {

	const UPLOAD_STAT_OK = 0;
	const UPLOAD_STAT_COPY = 1;
	const UPLOAD_STAT_DMKD = 2;
	const UPLOAD_STAT_ERR = 3;
	const UPLOAD_STAT_TYPE = 4;

	public static function getError($num) {
		switch($num) {
			case UPLOAD_ERR_OK : return "Ошибок не возникло, файл был успешно загружен на сервер."; break;
			case UPLOAD_ERR_INI_SIZE : return "Размер принятого файла превысил максимально допустимый размер"; break;
			case UPLOAD_ERR_FORM_SIZE : return "Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме."; break;
			case UPLOAD_ERR_PARTIAL : return "Загружаемый файл был получен только частично."; break;
			case UPLOAD_ERR_NO_FILE : return "Файл не был загружен."; break;
			case UPLOAD_ERR_NO_TMP_DIR : return "Отсутствует временная папка."; break;
			case UPLOAD_ERR_CANT_WRITE : return "Не удалось записать файл на диск."; break;
			case UPLOAD_ERR_EXTENSION : return "PHP-расширение остановило загрузку файла. PHP не предоставляет способа определить какое расширение остановило загрузку файла."; break;
		}
	}

	/**
	* Загрузка файла на сервер
	* @todo Запилить ограничения по размеру, по расширению
	* @return array()
	*/
	public static function upload($dir, $valid_types = null, $max_size = null) {
		if (!$valid_types)
			$valid_types = array("gif","jpg", "png", "jpeg", "doc", "docx", "zip");

		$status_result = array();

		if(isset($_FILES["uploadfiles"])) {
			$file_count = count($_FILES["uploadfiles"]["name"]);

			for ($i = 0; $i<$file_count; $i++) {
				$status_result[$i]["name"] = $_FILES["uploadfiles"]["name"][$i];
				$status_result[$i]["size"] = $_FILES["uploadfiles"]["size"][$i];
				$status_result[$i]["type"] = $_FILES["uploadfiles"]["type"][$i];
				$status_result[$i]["error"] = $_FILES["uploadfiles"]["error"][$i];
				$status_result[$i]["status"] = self::UPLOAD_STAT_ERR;

				if ($_FILES["uploadfiles"]["error"][$i] === UPLOAD_ERR_OK) {
					$ext = substr($_FILES['uploadfiles']['name'][$i], 1 + strpos($_FILES['uploadfiles']['name'][$i], "."));
					if (!in_array($ext, $valid_types)) {
						$status_result[$i]["status"] = self::UPLOAD_STAT_TYPE;
						continue;
					}

					if(is_uploaded_file($_FILES["uploadfiles"]["tmp_name"][$i])) {
						$status_result[$i]["code"] = md5(md5_file($_FILES["uploadfiles"]["tmp_name"][$i]).date("YmdHis"));

						if(!is_dir($dir))
							if (!mkdir($dir)) {
								$status_result[$i]["status"] = self::UPLOAD_STAT_DMKD;
								continue;
							}
						$dir .= DS.$status_result[$i]["code"];

						if (move_uploaded_file($_FILES["uploadfiles"]["tmp_name"][$i], $dir)) {
							$status_result[$i]["status"] = self::UPLOAD_STAT_OK;
						}
						else {
							$status_result[$i]["status"] = self::UPLOAD_STAT_COPY;
						}
					}
				}
			}
		}

		return $status_result;
	}
}