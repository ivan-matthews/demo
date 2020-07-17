<?php

	use Core\Classes\Kernel;
	use Core\Classes\Config;
	use Core\Classes\Router;
	use Core\Classes\Request;
	use Core\Classes\Database;
	use Core\Classes\Response;

	require __DIR__ . "/../loader.php";

	$config 	= Config::getInstance();
	$router 	= Router::getInstance();
	$request 	= Request::getInstance();
	$kernel 	= Kernel::getInstance();
	$database	= Database::getInstance();
	$response 	= Response::getInstance();

	$router->parseURL(fx_get_server('REQUEST_URI'));
	$router->setRoute();

	$request->setRequestMethod(fx_get_server('REQUEST_METHOD'));
	$request->setRequestedData(fx_get_request());

	$kernel->setProperty();
	$kernel->setControllerParams();
	$kernel->setActionParams();
	$kernel->loadSystem();


	fx_pre(
		$response->getResponseCode(),
		$response->getResponseStatus()
	);




	fx_pre(array(
		$router->getController(),
		$router->getAction(),
		$router->getParams(),
		$router->getRouterStatus(),
		$request->getAll()
	));

	fx_pre(
		get_included_files(),
		fx_prepare_memory(memory_get_usage()),
		number_format(microtime(true)-TIME,10),
		$response->getDebug()
	);



