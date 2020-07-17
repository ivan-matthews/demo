<?php

	use Core\Classes\Kernel;
	use Core\Classes\Config;
	use Core\Classes\Router;
	use Core\Classes\Request;
	use Core\Classes\Database;
	use Core\Classes\Response;
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



	fx_die(array(
		phpversion(),
		'memor'=>fx_prepare_memory(memory_get_usage(),4,',',' '),
		'times'=>number_format(microtime(true)-TIME,10),
	));












	fx_pre(array(
		'csrf'=>$user->getCSRFToken(),
		'code'=>$response->getResponseCode(),
		'stat'=>$response->getResponseStatus(),
		'data'=>$response->getData(),
		'grup'=>$user->getGroups(),
		'burl'=>$user->getBackUrl(),
	));


	fx_pre(array(
		'cnt'=>$router->getController(),
		'act'=>$router->getAction(),
		'prm'=>$router->getParams(),
		'sts'=>$router->getRouterStatus(),
		'all'=>$request->getAll(),
		'mtd'=>$request->getRequestMethod(),
//				'arr'=>fx_load_array('system/assets',Kernel::IMPORT_INCLUDE_ONCE),
//				'cnf'=>$config->getAll()
	));

	fx_pre(array(
		'cache'=>array(
			/*$this->model->indexModel(a(1)),
			$this->model->indexModel(a(1)),
			$this->model->indexModel(a(2)),
			$this->model->indexModel(a(2)),
			$this->model->indexModel(a(4)),
			$this->model->indexModel(a(4)),
			$this->model->indexModel(a(3)),
			$this->model->indexModel(a(3)),*/
		),
		'files'=>get_included_files(),
		'memor'=>fx_prepare_memory(memory_get_usage(),4,',',' '),
		'times'=>number_format(microtime(true)-TIME,10),

	));

	$dbg = $response->getDebug();
	if($dbg){
		foreach($dbg as $key=>$item){
			print "<i>{$key}</i><br>";
			foreach($item as $value){
				print $value['query'] .'<br>';
			}
			print '<hr>';
		}
	}
