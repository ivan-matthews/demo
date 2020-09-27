<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'feedback.controller_name',
		'resend_email'		=> null,
		'contacts_title'	=> 'feedback.contacts_title_value',
		'contacts_footer'	=> 'feedback.contacts_footer_value',
		'contact_info'		=> array(
			array(
				'country'	=> 'Украина',
				'region'	=> 'Запорожская обл',
				'city'		=> 'Запорожье',
				'street'	=> 'Соборный',
				'house'		=> '21',
				'apartment'	=> '120',
				'phones'	=> array(
					380991234567	=> false,
					380951234567	=> false,
					380661234567	=> false,
					380971234567	=> false
				),
				'emails'	=> array(
					'admin@m.c'			=> false,
					'support@m.c'		=> false,
					'system@m.c'		=> false,
					'info@m.c'			=> false,
					'help@m.c'			=> false,
					'feed@m.c'			=> false,
					'feedback@m.c'		=> false,
					'feedback-info@m.c'	=> false,
				),
			),
			array(
				'country'	=> 'Украина',
				'region'	=> 'Днепропетровская обл',
				'city'		=> 'Днепр',
				'street'	=> 'Соборный',
				'house'		=> '21',
				'apartment'	=> '120',
				'phones'	=> array(
					380991234567	=> false,
					380951234567	=> false,
					380661234567	=> false,
					380971234567	=> false
				),
				'emails'	=> array(
					'admin@m.c'			=> false,
					'support@m.c'		=> false,
					'system@m.c'		=> false,
					'info@m.c'			=> false,
					'help@m.c'			=> false,
					'feed@m.c'			=> false,
					'feedback@m.c'		=> false,
					'feedback-info@m.c'	=> false,
				),
			),
		),
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'	=> array(
			'index'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'item'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
			'send'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'requests'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
			'read'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
			'reply'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
			'delete'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
		),
		'sorting_panel'	=> array(
			'all'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'feedback.all_bids_sorting',
				'link'	=> array('feedback','requests','all'),
				'icon'	=> null,
			),
			'new'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'feedback.new_bids_sorting',
				'link'	=> array('feedback','requests','new'),
				'icon'	=> null,
			),
			'old'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'feedback.old_bids_sorting',
				'link'	=> array('feedback','requests','old'),
				'icon'	=> null,
			),
		),
	);
