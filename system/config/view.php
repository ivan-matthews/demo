<?php

	use Core\Classes\User;

	return array(
		'site_theme'			=> 'default',	// +
		'admin_theme'			=> 'admin',		// +-
		'title_delimiter'		=> ' &rarr; ',
//		'title_delimiter'		=> ' :: ',
		'breadcrumbs_on_main'	=> true,		// +
		'default_favicon'		=> 'site/favicon.png',
		'site_logo'				=> 'site/logo_2.png',
		'uploads_dir'			=> 'uploads',
		'tpl_files_host'		=> null,

		'user_avatar'	=> array(
			User::GENDER_NONE	=> array(
				'micro'		=> 'images/avatars/micro122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'small'		=> 'images/avatars/small122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'medium'	=> 'images/avatars/medium122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'normal'	=> 'images/avatars/normal122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'big'		=> 'images/avatars/big122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'original'	=> 'images/avatars/original122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
			),
			User::GENDER_MALE	=> array(
				'micro'		=> 'images/avatars/micro122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'small'		=> 'images/avatars/small122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'medium'	=> 'images/avatars/medium122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'normal'	=> 'images/avatars/normal122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'big'		=> 'images/avatars/big122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
				'original'	=> 'images/avatars/original122b22ae96d2c8e934e31b6c84ced4d1e.jpeg',
			),
			User::GENDER_FEMALE => array(
				'micro'		=> 'images/avatars/micro1e9e31c73ecb68b837339c0d8bdc963f9.jpeg',
				'small'		=> 'images/avatars/small1e9e31c73ecb68b837339c0d8bdc963f9.jpeg',
				'medium'	=> 'images/avatars/medium1e9e31c73ecb68b837339c0d8bdc963f9.jpeg',
				'normal'	=> 'images/avatars/normal1e9e31c73ecb68b837339c0d8bdc963f9.jpeg',
				'big'		=> 'images/avatars/big1e9e31c73ecb68b837339c0d8bdc963f9.jpeg',
				'original'	=> 'images/avatars/original1e9e31c73ecb68b837339c0d8bdc963f9.jpeg',
			)
		),
		'broken_image'	=> array(
			'micro'		=> 'images/not-found/micro-nf.jpeg',
			'small'		=> 'images/not-found/small-nf.jpeg',
			'medium'	=> 'images/not-found/medium-nf.jpeg',
			'normal'	=> 'images/not-found/normal-nf.jpeg',
			'big'		=> 'images/not-found/big-nf.jpeg',
			'original'	=> 'images/not-found/original-nf.jpeg',
		),
	);
