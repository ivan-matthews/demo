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
	$hooks		= Hooks::getInstance();

	for($i=0;$i<1000;$i++){
		$login = fx_gen_lat(rand(15,30)) . '@' . fx_gen_lat(rand(15,30)) . '.'. fx_gen_lat(rand(2,5));

		$fname = fx_mb_ucfirst(fx_gen_cyr_name(rand(4,10)));
		$lname = fx_mb_ucfirst(fx_gen_cyr_name(rand(4,10)));
		$fullname = "{$fname} {$lname}";

		$auth_id = Database::insert('auth')->value('login',$login)
			->value('password',fx_encode('Qwerty12345^'))
			->value('enc_password',fx_encryption('Qwerty12345^'))
			->value('groups',array(1))
			->value('bookmark',fx_encode($login.'Qwerty12345^'))
			->value('date_activate',time())
			->value('status',Kernel::STATUS_ACTIVE)
			->get()
			->id();
		$online_time = 900+time();
		Database::insert('users')->value('auth_id',$auth_id)
			->value('first_name',$fname)
			->value('last_name',$lname)
			->value('full_name',$fullname)
			->value('gender',rand(User::GENDER_MALE,User::GENDER_NONE))
			->value('avatar_id',$auth_id)
			->value('status_id',$auth_id)
			->value('country_id',$auth_id)
			->value('city_id',$auth_id)
			->value('birth_day',rand(1,31))
			->value('birth_month',rand(1,12))
			->value('birth_year',rand(1900,2010))
			->value('phone','+2123433245324')
			->value('cophone','+24234325223324')
			->value('email',$login)
			->value('icq','321443575')
			->value('skype',$login)
			->value('viber',$login)
			->value('whatsapp',$login)
			->value('telegram',$login)
			->value('website','http://m.c')
			->value('activities','NaN')
			->value('interests','NaN')
			->value('music','NaN')
			->value('films','NaN')
			->value('shows','NaN')
			->value('books','NaN')
			->value('games','NaN')
			->value('citates','NaN')
			->value('about','NaN')
			->value('date_log',$online_time)
			->value('log_type',rand(User::LOGGED_DESKTOP,User::LOGGED_DEFAULT))
			->value('date_created',time())
			->value('status',rand(Kernel::STATUS_INACTIVE,Kernel::STATUS_BLOCKED))
			->get()
			->id();
	}

















