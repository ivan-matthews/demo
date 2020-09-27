<?php

	use Core\Classes\Database\Database;
	use Core\Classes\Response\Response;
	use Core\Classes\Language;
	use Core\Classes\Session;
	use Core\Classes\Widgets;
	use Core\Classes\Request;
	use Core\Classes\Kernel;
	use Core\Classes\Config;
	use Core\Classes\Router;
	use Core\Classes\Hooks;
	use Core\Classes\User;
	use Core\Classes\View;

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
	$widgets	= Widgets::getInstance();

	$hooks->before('session_start');
	$session->setSessionDir(null);
	$session->setSessionID();
	$session->setSessionFile();
	if(!$hooks->instead('session_start')){
		$session->sessionStart();
	}
	$hooks->after('session_start');

	$hooks->before('set_language');
	$language->setServerLanguageHeader($request->get('language')?:fx_get_server('HTTP_ACCEPT_LANGUAGE'));
	$language->setLanguageKey();
	if(!$hooks->instead('set_language')){
		$language->setLanguage();
	}
	$hooks->after('set_language');

	$hooks->before('parse_url');
	$router->parseURL($request->get('link')?:fx_get_server('REQUEST_URI'));
	if(!$hooks->instead('parse_url')){
		$router->setRoute();
	}
	$hooks->after('parse_url');

	$hooks->before('controller_run');
	$kernel->loadLinkReplaceList();
	$kernel->setProperty();
	$kernel->setControllerParams();
	$kernel->setActionParams();
	if(!$hooks->instead('controller_run')){
		$kernel->loadSystem();
	}
	$hooks->after('controller_run');

	$hooks->before('widgets_run');
	if(!$hooks->instead('widgets_run')){
		$widgets->execute();
	}
	$hooks->after('widgets_run');

	$hooks->before('render_data');
	$view->setRenderType($request->get('accept')?:fx_get_server('HTTP_ACCEPT'));
	$view->ready();
	if(!$hooks->instead('render_data')){
		$view->start();
	}
	$hooks->after('render_data');

	$hooks->after('load_system');