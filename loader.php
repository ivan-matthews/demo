<?php

	require __DIR__ . "/core/helpers/autoload/functions_loader.php";

	define('TIME',microtime(true));
	define('ROOT',dirname(__FILE__));

	error_reporting(E_ALL);
	ini_set('display_errors','1');
	ini_set('xdebug.max_nesting_level','1024');

	date_default_timezone_set('Europe/London');	// Дефолтный пояс - Лондон, для БД
	fx_load_helpers();											// Подключаем хелперы
	spl_autoload_register('fx_classes_loader'); 	// Загружаем классы

















