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

		$auth_id = Database::insert('auth')
			->value('a_login',$login)
			->value('a_password',fx_encode('Qwerty12345^'))
			->value('a_enc_password',fx_encryption('Qwerty12345^'))
			->value('a_groups',array(1))
			->value('a_bookmark',fx_encode($login.'Qwerty12345^'))
			->value('a_date_activate',time())
			->value('a_status',Kernel::STATUS_ACTIVE)
			->get()
			->id();
		$online_time = 900+time();
		Database::insert('users')
			->value('u_auth_id',$auth_id)
			->value('u_first_name',$fname)
			->value('u_last_name',$lname)
			->value('u_full_name',$fullname)
			->value('u_gender',rand(User::GENDER_MALE,User::GENDER_NONE))
			->value('u_avatar_id',$auth_id)
			->value('u_status_id',$auth_id)
			->value('u_country_id',$auth_id)
			->value('u_city_id',$auth_id)
			->value('u_birth_day',rand(1,31))
			->value('u_birth_month',rand(1,12))
			->value('u_birth_year',rand(1900,2010))
			->value('u_phone','+2123433245324')
			->value('u_cophone','+24234325223324')
			->value('u_email',$login)
			->value('u_icq','321443575')
			->value('u_skype',$login)
			->value('u_viber',$login)
			->value('u_whatsapp',$login)
			->value('u_telegram',$login)
			->value('u_website','http://m.c')
			->value('u_activities','NaN')
			->value('u_interests','NaN')
			->value('u_music','NaN')
			->value('u_films','NaN')
			->value('u_shows','NaN')
			->value('u_books','NaN')
			->value('u_games','NaN')
			->value('u_citates','NaN')
			->value('u_about','NaN')
			->value('u_date_log',$online_time)
			->value('u_log_type',rand(User::LOGGED_DESKTOP,User::LOGGED_DEFAULT))
			->value('u_date_created',time())
			->value('u_status',rand(Kernel::STATUS_INACTIVE,Kernel::STATUS_BLOCKED))
			->get()
			->id();
	}

















