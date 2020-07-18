<?php

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Classes\Config;
	use Core\Classes\Router;
	use Core\Classes\Request;
	use Core\Classes\Response;
	use Core\Classes\Session;
	use Core\Classes\Language;
	use Core\Classes\User;
	use Core\Classes\View;
	use Core\Classes\Hooks;

	require __DIR__ . "/../loader.php";

	$hooks	= Hooks::getInstance();

	$hooks->before('load_system');

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

	$hooks->before('session_start');
	$session->setSessionDir(null);
	$session->setSessionID();
	$session->setSessionFile();
	$session->checkSessionFile();
	$session->sessionStart();
	$hooks->after('session_start');

	$hooks->before('set_language');
	$language->setServerLanguageHeader($request->get('language')?:fx_get_server('HTTP_ACCEPT_LANGUAGE'));
	$language->setLanguageKey();
	$language->setLanguage();
	$hooks->after('set_language');

	$hooks->before('parse_url');
	$router->parseURL($request->get('link')?:fx_get_server('REQUEST_URI'));
	$router->setRoute();
	$hooks->after('parse_url');

	$hooks->before('controller_run');
	$kernel->setProperty();
	$kernel->setControllerParams();
	$kernel->setActionParams();
	$kernel->loadSystem();
	$hooks->after('controller_run');

	$hooks->before('render_data');
	$view->setRenderType($request->get('accept')?:fx_get_server('HTTP_ACCEPT'));
	$view->ready();
	$view->start();
	$hooks->after('render_data');

	$hooks->after('load_system');











