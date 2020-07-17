<?php

	use Core\Classes\Kernel;
	use Core\Classes\Config;
	use Core\Classes\Router;
	use Core\Classes\Request;
	use Core\Classes\Database;
	use Core\Classes\Response;
	use Core\Classes\Session;
	use Core\Console\Console;		// Run console scripts from web-page (details: Console::run('help',1))

	require __DIR__ . "/../loader.php";

	$config 	= Config::getInstance();
	$router 	= Router::getInstance();
	$request 	= Request::getInstance();
	$kernel 	= Kernel::getInstance();
	$database	= Database::getInstance();
	$response 	= Response::getInstance();
	$session	= Session::getInstance();

	$request->setRequestedData(fx_get_request());
	$request->setRequestMethod(fx_get_server('REQUEST_METHOD'));

	$session->setSessionDir();
	$session->setSessionID();
	$session->setSessionFile();
	$session->checkSessionFile();
	$session->sessionStart();
	$session->validateAuthorize();
	$session->refreshAuthCookieTime();

	$router->parseURL(fx_get_server('REQUEST_URI'));
	$router->setRoute();

	$kernel->setProperty();
	$kernel->setControllerParams();
	$kernel->setActionParams();
	$kernel->loadSystem();



