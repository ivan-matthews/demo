<?php

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Classes\Config;
	use Core\Classes\Router;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Classes\Session;
	use Core\Classes\Language;
	use Core\Classes\User;
	use Core\Classes\View;

	require __DIR__ . "/../loader.php";

	$config 	= Config::getInstance();
	$router 	= Router::getInstance();
	$request 	= Request::getInstance();
	$kernel 	= Kernel::getInstance();
	$database	= Database::getInstance();
	$response 	= Response::getInstance();
	$session	= Session::getInstance();
	$language	= Language::getInstance();
	$user 		= User::getInstance();
	$view		= View::getInstance();

	$session->setSessionDir(null);
	$session->setSessionID();
	$session->setSessionFile();
	$session->checkSessionFile();
	$session->sessionStart();

	$language->setServerLanguageHeader($request->get('language')?:fx_get_server('HTTP_ACCEPT_LANGUAGE'));
	$language->setLanguageKey();
	$language->setLanguage();

	$user->validateAuthorize();
	$user->refreshAuthCookieTime();
	$user->resetCSRFToken();

	$router->parseURL($request->get('link')?:fx_get_server('REQUEST_URI'));
	$router->setRoute();

	$kernel->setProperty();
	$kernel->setControllerParams();
	$kernel->setActionParams();
	$kernel->loadSystem();

	$view->setRenderType($request->get('accept')?:fx_get_server('HTTP_ACCEPT'));
	$view->ready();
	$view->start();


	




