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


	fx_pre(array(
		'code'=>$response->getResponseCode(),
		'stat'=>$response->getResponseStatus(),
	));


	fx_pre(array(
		'cnt'=>$router->getController(),
		'act'=>$router->getAction(),
		'prm'=>$router->getParams(),
		'sts'=>$router->getRouterStatus(),
		'all'=>$request->getAll(),
//				'arr'=>fx_load_array('system/assets',Kernel::IMPORT_INCLUDE_ONCE),
//				'cnf'=>$config->getAll()
	));

	function a($iterations){
		$result = array();
		for($i=0;$i<$iterations;$i++){ $result[$i] = 'string_random'; }
		return $result;
	}

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
//			Database::select('*')->from('migrations')->exec();
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