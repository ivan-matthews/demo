<?php

	define('TIME',microtime(true));
	define('ROOT',__DIR__);

	require ROOT . "/core/helpers/autoload/autoloader.php";
	require ROOT . "/vendor/autoload.php";

	error_reporting(1);
//	set_time_limit(5);
	ini_set('display_errors','1');
	ini_set('xdebug.max_nesting_level','4192');

	date_default_timezone_set('Europe/London');		// Дефолтный пояс - Лондон, для БД
	fx_load_helpers();												// Подключаем хелперы
	spl_autoload_register('autoLoader::autoload'); 	// Загружаем классы

	set_error_handler("Core\\Classes\\Error::getInstance");
	register_shutdown_function('Core\\Classes\\Error::setError');

















