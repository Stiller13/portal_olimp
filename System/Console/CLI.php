<?php
namespace System\Console;

class CLI {
	const VERSION = "0.1";

	public function info(){
		$this->info_header();
		echo "Usage:\n";
		echo "\tphp index.php <testFile> - run test file in ConferenceHub environment\n";
		echo "Example: \n\tphp index.php foo - will run foo.php in /test directory\n";
	}

	public function info_header(){
		echo "ConferenceHub CLI\n\n";
		echo "CH version: NO_VERSION_SPECIFIED\n";
		echo "CLI version: ".self::VERSION."\n\n";
	}

	public function main($argc, $argv){

		if($argc == 1){
			$this->info();
		}elseif($argc == 2){
			$eFilename = $argv[1];
			$ePath = ROOT.DS."test".DS.$eFilename.".php";
			if(is_readable($ePath)){
				echo "\n\n***************************\n";
				include($ePath);
			}else{
				echo "Script ".$ePath." not found\n";
			}
		}else{
			echo "Too many parameters\n";
		}
	}
}
