<?php

	define('TIME',microtime(true));
	define('ROOT',dirname(__FILE__));

	require __DIR__ . "/vendor/autoload.php";
	require __DIR__ . "/core/helpers/autoload/functions_loader.php";

	error_reporting(0);
	ini_set('display_errors','0');
	ini_set('xdebug.max_nesting_level','1024');

	date_default_timezone_set('Europe/London');	// Дефолтный пояс - Лондон, для БД
	fx_load_helpers();											// Подключаем хелперы
	spl_autoload_register('fx_classes_loader'); 	// Загружаем классы

	set_error_handler("Core\\Classes\\Error::getInstance");
	register_shutdown_function('Core\\Classes\\Error::setError');

















