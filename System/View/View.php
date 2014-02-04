<?php
namespace System\View;

use \System\Core\Application as App;

class View {
	private $_smarty;
	const SMARTY_POSTFIX = ".tpl";

	public function __construct(){
		include ROOT.DS."smarty".DS."Smarty.class.php";
		$this->_smarty = new \Smarty;
		$this->_smarty->compile_dir = TMP.DS."smarty_templates_c";
		$this->_smarty->cache_dir = TMP.DS."smarty_cache";
		// $f = fopen(TMP.DS."f", "rw");
		// fwrite($f, "i");
		// fclose($f);
		// echo "HI!";
	}

	public function assign($key, $val = null){
		if(is_null($val)){
			$this->_smarty->assign($key);
		}else{
			$this->_smarty->assign($key, $val);
		}
	}

	public function render($template){
		$tpl_path = APP.DS.App::DIR_VIEW.DS.$template . self::SMARTY_POSTFIX;
		if(!is_readable($tpl_path)){
			throw new \Exception("Unable to load template ".$tpl_path);
		}
		return $this->_smarty->fetch($tpl_path);
	}
}