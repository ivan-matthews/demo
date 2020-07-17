<?php

	$_SERVER['PHP_SELF'] = '/view/server.php';

	if($_SERVER['REQUEST_URI'] !== '/'){
		if(($pos = mb_strpos($_SERVER['REQUEST_URI'],'?')) !== false){
			$_SERVER['REQUEST_URI'] = mb_substr($_SERVER['REQUEST_URI'],0,$pos);
		}
		if(file_exists(__DIR__ . $_SERVER['REQUEST_URI']) && !is_dir(__DIR__ . $_SERVER['REQUEST_URI'])){
			return false;
		}
	}

	include __DIR__ . "/public/index.php";















