<?php

	/** Cron task add to /etc/crontab | sudo service cron restart:
	 *|
	 *| * * * * * root php /var/www/m.c/cli cron run > /var/www/m.c/cron.log 2>&1
	 *|
	 */

	use Core\Console\Console;
	use Core\Classes\Config;
	use Core\Classes\Request;

	require __DIR__ . "/../loader.php";

	$config = Config::getInstance();
	$request = Request::getInstance();

	$request->setRequestedData(fx_get_request());
	$request->setRequestMethod(fx_get_server('REQUEST_METHOD'));

	if(fx_equal($config->cron['validation_key'],$request->get('key'))
		&& fx_equal($config->cron['validation_token_key'],$request->get('token'))){
		return Console::run('cron','run');
	}
	print 'Some problem...';
