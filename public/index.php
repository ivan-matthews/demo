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













/*
	$db = Database::getInstance();
	$db->useDb('mc');

	update_geo_cities();

	function update_geo_cities($update_field='gc_title_cyr',$lang="ru",$limit=1000){
		$ids_list = Database::select('gc_city_id')
			->from('geo_cities')
			->where("isnull({$update_field})")
			->limit($limit)
			->get()->allAsArray();

		if(!$ids_list){
			unset($ids_list);
			if($update_field == 'gc_title_cyr' && $lang == 'ru'){
				fx_die('cyr off...');
				return update_geo_cities('gc_title_lat',"en");
			}
			if($update_field == 'gc_title_lat' && $lang == 'en'){
				fx_die('lat off...');
				return true;
			}
			fx_die('empty ids list...');
			return false;
		}

		$ids = '';
		foreach($ids_list as $item){
			$ids .= "{$item['gc_city_id']},";
		}
		$ids = trim($ids,",");

		$content = http_build_query(array(
			'city_ids'		=> $ids,
			"lang"			=> $lang,
			'v'				=> '5.120',
			'access_token'	=> Config::getInstance()->api['vk']['access_token']
		));
		$opts = array(
			'http'=>array(
				'method'=>"POST",
				'header'=>
					"Content-Length: ".strlen($content)."\r\n".
					"Content-Type: application/x-www-form-urlencoded\r\n"
			,

				'content' => $content,
			)
		);
		$context = stream_context_create($opts);

		$response_from_vk = file_get_contents("https://api.vk.com/method/database.getCitiesById", false, $context);
		$response_from_vk = json_decode($response_from_vk,1);
		if(!isset($response_from_vk['response'])){
			fx_die($response_from_vk);
			unset($ids_list,$response_from_vk,$content,$context,$opts,$item,$ids);
			return false;
		}
		if(isset($response_from_vk['response'])){
			foreach($response_from_vk['response'] as $item_response){
				Database::update('geo_cities')
					->field($update_field,$item_response['title'])
					->where("`gc_city_id`='{$item_response['id']}'")
					->get()->rows();
			}
		}

		unset($ids_list,$response_from_vk,$content,$context,$opts,$item,$ids,$item_response);
		return update_geo_cities($update_field,$lang);
	}
*/

/*
	fx_make_dir('/var/www/m.c/system/migrations/inserts/geo/cities');
	fx_make_dir('/var/www/m.c/system/migrations/inserts/geo/countries');
	fx_make_dir('/var/www/m.c/system/migrations/inserts/geo/regions');

	$db = Database::getInstance();
	$db->useDb('mc');

	add_cities();

	function add_cities($limit=1000,$offset=0){
		if(is_readable(fx_path("system/migrations/inserts/geo/cities/{$offset}.php"))){
			$offset = $offset+$limit;
			return add_cities($limit,$offset);
		}
		$cities = Database::select(
			'gc_city_id','gc_country_id','gc_region','gc_area','gc_title','gc_title_ru','gc_title_en'
		)
			->from("geo_cities")
			->limit($limit)
			->offset($offset)
			->get()
			->allAsArray();
		if(!$cities){
			return false;
		}
		fx_save("system/migrations/inserts/geo/cities/{$offset}.php",fx_php_encode($cities));
		$offset = $offset+$limit;
		unset($cities);
		return add_cities($limit,$offset);
	}
*/
/*
	$f = include "/var/www/m.c/system/migrations/inserts/geo/cities/160000.php";
	$ids_arr = array();
	foreach($f as $item){
		$ids_arr[] = $item['gc_id'];
	}
	$ids=implode(',',$ids_arr);
	unset($f,$ids_arr,$item);

	$content = http_build_query(array(
		'city_ids'		=> $ids,
		"lang"			=> 'ru',
		'v'				=> '5.120',
		'access_token'	=> Config::getInstance()->api['vk']['access_token']
	));
	$opts = array(
		'http'=>array(
			'method'=>"POST",
			'header'=>
				"Content-Length: ".strlen($content)."\r\n".
				"Content-Type: application/x-www-form-urlencoded\r\n"
		,

			'content' => $content,
		)
	);
	$context = stream_context_create($opts);

	fx_die(file_get_contents("https://api.vk.com/method/database.getCitiesById", false, $context));

*/

