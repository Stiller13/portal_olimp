<?php
namespace System\Utils;

class URIParser {
	/**
	* Выделяет префикс из строки запроса и расположения сайта, чтобы
	* использовать его в формировании ссылок
	* @todo:
	*		Проблемы: Для /adewaie D:/adewa возвращается /adewa
	* 	быдлокодинг некритичен, но пофиксить
	*/
	public static function extractPrefix( $uri, $upt=ROOT ){
		$upt = str_replace(DS, "/", $upt);

		$max_collisions = 0;
		$mc_cmp_number = 0;

		for($cmp_number = 1; $cmp_number <= min( strlen($uri), strlen($upt) ); ++$cmp_number){
			$collisions = 0;
			// much way cheaper than substr() == substr()
			for(
				$uri_pos = 0,
				$upt_pos = strlen($upt)-$cmp_number;

				$uri_pos < $cmp_number;

				++$uri_pos, ++$upt_pos
			){
				if( $upt[$upt_pos] != $uri[$uri_pos] ){
					$collisions = 0;
					break;
				}else{
					++$collisions;
				}
			}

			if($collisions > $max_collisions){
				$max_collisions = $collisions;
				$mc_cmp_number = $cmp_number;
			}
		}

		if($mc_cmp_number == 0){
			return "";
		}
		
		return substr($uri, 0, $mc_cmp_number);
	}

	/**
	* Убирает вышестоящие директории из запроса
	*/
	public static function extractRequest($uri){
		$prefix_lh = strlen(self::extractPrefix($uri));


		if($prefix_lh > 0){
			$res = substr($uri, $prefix_lh, strlen($uri) - $prefix_lh);
		}else{
			$res = $uri;
		}
		// foo/bar/ => foo/bar
		if($res != "/"){
			if( $res[strlen($res) - 1] == "/" ){
				$res = substr($res, 0, strlen($res) - 1);
			}
		}

		return $res;
	}
}