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
				'country'	=> 'Russian Federation',
				'region'	=> 'Moscow',
				'city'		=> 'Moscow city',
				'street'	=> 'Lenina',
				'house'		=> '21',
				'apartment'	=> '984375',
				'phones'	=> array(
					1043634643651,102234523535,1034574576457645,10423452452345243
				),
				'emails'	=> array(
					'aadssfdsafasfdas@m.c','bdfgdsgfdsgfsdgf@m.c','csdgfsdgsdgsdgsdg@m.c',
					'asfasfdasfdasfasdfd@m.c','sdgsdgfsdfgsdgfsdgfsdge@m.c','fssfdgsfdgsdgfsdg@m.c',
					'sdgsdgfsdgfsdgfsdfgsdsdgfs-dgfsdgsdgf-sdgfg@m.c','asfasfdasfasfdasfdasfd-ash@m.c',
				),
			),
			array(
				'country'	=> 'Russian Federation',
				'region'	=> 'Leningrad',
				'city'		=> 'st. Petersburg',
				'street'	=> 'Lenina',
				'house'		=> '21',
				'apartment'	=> '234251',
				'phones'	=> array(
					1043634643651,102234523535,1034574576457645,10423452452345243
				),
				'emails'	=> array(
					'aadssfdsafasfdas@m.c','bdfgdsgfdsgfsdgf@m.c','csdgfsdgsdgsdgsdg@m.c',
					'asfasfdasfdasfasdfd@m.c','sdgsdgfsdfgsdgfsdgfsdge@m.c','fssfdgsfdgsdgfsdg@m.c',
					'sdgsdgfsdgfsdgfsdfgsdsdgfs-dgfsdgsdgf-sdgfg@m.c','asfasfdasfasfdasfdasfd-ash@m.c',
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
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'send'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'list'	=> array(
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