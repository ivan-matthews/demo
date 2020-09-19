<?php

	$_SERVER['PHP_SELF'] = '/public/server.php';

	$current_path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

	if($current_path !== '/'){
		if(file_exists(__DIR__ . $current_path)){
			return false;
		}
	}

	include __DIR__ . "/public/index.php";















