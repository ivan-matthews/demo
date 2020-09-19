<?php

	use Core\Classes\User;

	return array(
		'site_theme'			=> 'default',	// +
		'admin_theme'			=> 'admin',		// +-
		'title_delimiter'		=> ' &rsaquo; ',
//		'title_delimiter'		=> ' &rarr; ',
//		'title_delimiter'		=> ' :: ',
		'breadcrumbs_on_main'	=> false,		// +
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
		'files_icons'	=> array(
			'default'	=> 'fas fa-file',
			'exe'		=> 'fab fa-windows',
			'msi'		=> 'fab fa-windows',
			'apk'		=> 'fas fa-robot',
			'ipa'		=> 'fab fa-apple',
			'zip'		=> 'far fa-file-archive',
			'rar'		=> 'far fa-file-archive',
			'7z'		=> 'far fa-file-archive',
			'doc'		=> 'far fa-file-word',
			'docx'		=> 'far fa-file-word',
			'odt'		=> 'far fa-file-word',
			'ppt'		=> 'far fa-file-powerpoint',
			'pptx'		=> 'far fa-file-powerpoint',
			'odp'		=> 'far fa-file-powerpoint',
			'xls'		=> 'far fa-file-excel',
			'xlsx'		=> 'far fa-file-excel',
			'ods'		=> 'far fa-file-excel',
			'odf'		=> 'fas fa-file-medical-alt',
			'pdf'		=> 'far fa-file-pdf',
			'jpg'		=> 'far fa-file-image',
			'jpeg'		=> 'far fa-file-image',
			'png'		=> 'far fa-file-image',
			'gif'		=> 'far fa-file-image',
			'bmp'		=> 'far fa-file-image',
			'webm'		=> 'far fa-file-image',
			'mp3'		=> 'far fa-file-audio',
			'wav'		=> 'far fa-file-audio',
			'ogg'		=> 'far fa-file-audio',
			'mpeg'		=> 'far fa-file-audio',
			'mp4'		=> 'far fa-file-video',
			'flv'		=> 'far fa-file-video',
			'csv'		=> 'far fa-file-csv',
			'txt'		=> 'far fa-file-alt',
		),
	);
