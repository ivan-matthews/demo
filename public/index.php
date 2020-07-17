<?php

	use Core\Classes\Kernel;
	use Core\Classes\Config;
	use Core\Classes\Router;
	use Core\Classes\Request;
	use Core\Classes\DB;

	require __DIR__ . "/../autoloader.php";

	$config = Config::getInstance();
	$router = Router::getInstance();
	$kernel = Kernel::getInstance();
	$request = Request::getInstance();

	$router->parseURL(fx_get_server('REQUEST_URI'));
	$router->setRoute();

	$request->setRequestMethod(fx_get_server('REQUEST_METHOD'));
	$request->setRequestedData(fx_get_request());

	








	fx_pre(array(
		$router->getController(),
		$router->getAction(),
		$router->getParams(),
		$router->getRouterStatus(),
		$request->getAll(),
	));

	fx_pre(
//		get_included_files(),
		fx_prepare_memory(memory_get_usage()),
		number_format(microtime(true)-TIME,10)
	);





