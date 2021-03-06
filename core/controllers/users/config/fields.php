<?php

	use Core\Classes\User;

	return array(
		array(
			'field'	=> 'u_first_name',
			'jevix'	=> true,
			'max'	=> 95,
			'params'	=> array(
				'item_position'	=> 'visible',
				'show_in_item'	=> false,
				'show_in_filter'=> false,
				'show_validation'	=> false,
				'field_sets'	=> 'field_set_name',
				'render_type'	=> 'text',
				'label'			=> fx_lang('users.first_name'),
			),
		),
		array(
			'field'	=> 'u_last_name',
			'jevix'	=> true,
			'max'	=> 95,
			'params'	=> array(
				'item_position'	=> 'visible',
				'show_in_item'	=> false,
				'show_in_filter'=> false,
				'show_validation'	=> false,
				'field_sets'	=> 'field_set_name',
				'render_type'	=> 'text',
				'label'			=> fx_lang('users.last_name'),
			),
		),
		array(
			'field'	=> 'u_full_name',
			'jevix'	=> true,
			'placeholder'	=> fx_lang('users.full_name_placeholder'),
			'max'	=> 191,
			'params'	=> array(
				'filter_validation'	=> 'LIKE',
				'filter_position'=> 'visible',
				'field_sets'	=> 'field_set_name',
				'item_position'	=> 'visible',
				'show_in_form'	=> false,
				'show_label_in_form'	=> false,
				'show_in_item'	=> false,
				'show_validation'	=> false,
				'render_type'	=> 'text',
				'label'			=> fx_lang('users.full_name'),
			),
		),
/*		array(
			'field'	=> 'u_country_id',
			'placeholder'	=> fx_lang('users.country_placeholder'),
			'params'	=> array(
				'field_type' 	=> 'geo',
				'show_validation'	=> false,
				'item_position'	=> 'visible',
				'field_sets'	=> 'field_set_geo',
				'render_type'	=> 'geo',
				'label'			=> fx_lang('users.country'),
			),
		),
		array(
			'field'	=> 'u_region_id',
			'placeholder'	=> fx_lang('users.region_placeholder'),
			'params'	=> array(
				'field_type' 	=> 'geo',
				'show_validation'	=> false,
				'item_position'	=> 'visible',
				'field_sets'	=> 'field_set_geo',
				'render_type'	=> 'geo',
				'label'			=> fx_lang('users.region'),
			),
		),
		array(
			'field'	=> 'u_city_id',
			'placeholder'	=> fx_lang('users.city_placeholder'),
			'params'	=> array(
				'field_type' 	=> 'geo',
				'show_validation'	=> false,
				'item_position'	=> 'visible',
				'field_sets'	=> 'field_set_geo',
				'render_type'	=> 'geo',
				'label'			=> fx_lang('users.city'),
			),
		),*/
		array(
			'field'	=> 'u_gender',
			'jevix'	=> true,
			'max'	=> 1,
			'params'	=> array(
				'field_type' 	=> 'select',
				'show_validation'	=> false,
				'item_position'	=> 'visible',
				'field_sets'	=> 'field_set_name',
				'render_type'	=> 'gender',
				'label'			=> fx_lang('users.gender'),
				'variants'		=> array(
					User::GENDER_MALE 	=> fx_lang("users.user_gender_" . User::GENDER_MALE),
					User::GENDER_FEMALE => fx_lang("users.user_gender_" . User::GENDER_FEMALE),
					User::GENDER_NONE 	=> fx_lang("users.user_gender_" . User::GENDER_NONE),
				)
			),
		),
		array(
			'field'	=> 'u_birth_day',
			'jevix'	=> true,
			'max'	=> 2,
			'params'	=> array(
				'field_type' 	=> 'select',
				'show_validation'	=> false,
				'item_position'	=> 'visible',
				'field_sets'	=> 'field_set_birth_date',
				'render_type'	=> 'date',
				'label'			=> fx_lang('users.birth_day'),
				'variants'		=> array_combine(range(1,31),range(1,31)),
			),
		),
		array(
			'field'	=> 'u_birth_month',
			'max'	=> 2,
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'select',
				'show_validation'	=> false,
				'item_position'	=> 'visible',
				'field_sets'	=> 'field_set_birth_date',
				'render_type'	=> 'date',
				'label'			=> fx_lang('users.birth_month'),
				'variants'		=> array(
					1	=> fx_lang('home.month_nom_1'),
					2	=> fx_lang('home.month_nom_2'),
					3	=> fx_lang('home.month_nom_3'),
					4	=> fx_lang('home.month_nom_4'),
					5	=> fx_lang('home.month_nom_5'),
					6	=> fx_lang('home.month_nom_6'),
					7	=> fx_lang('home.month_nom_7'),
					8	=> fx_lang('home.month_nom_8'),
					9	=> fx_lang('home.month_nom_9'),
					10	=> fx_lang('home.month_nom_10'),
					11	=> fx_lang('home.month_nom_11'),
					12	=> fx_lang('home.month_nom_12'),
				),
			),
		),
		array(
			'field'	=> 'u_birth_year',
			'max'	=> 4,
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'select',
				'show_validation'	=> false,
				'item_position'	=> 'visible',
				'field_sets'	=> 'field_set_birth_date',
				'render_type'	=> 'date',
				'label'			=> fx_lang('users.birth_year'),
				'variants'		=> array_combine(range(1900,2020),range(1900,2020)),
			),
		),
		array(
			'field'	=> 'u_family',
			'jevix'	=> true,
			'max'	=> 1,
			'params'	=> array(
				'field_type' 	=> 'select',
				'show_validation'	=> false,
				'item_position'	=> 'visible',
				'field_sets'	=> 'field_set_name',
				'render_type'	=> 'family',
				'label'			=> fx_lang('users.family'),
				'variants'		=> array(
					1	=> fx_lang('users.users_family_1'),
					2	=> fx_lang('users.users_family_2'),
					3	=> fx_lang('users.users_family_3'),
					4	=> fx_lang('users.users_family_4'),
					5	=> fx_lang('users.users_family_5'),
				)
			),
		),
		array(
			'field'	=> 'u_phone',
			'max'	=> 20,
			'jevix'	=> true,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'phone',
				'label'			=> fx_lang('users.phone'),
			),
		),
		array(
			'field'	=> 'u_cophone',
			'max'	=> 20,
			'jevix'	=> true,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'phone',
				'label'			=> fx_lang('users.cophone'),
			),
		),
		array(
			'field'	=> 'u_email',
			'jevix'	=> true,
			'max'	=> 191,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'email',
				'label'			=> fx_lang('users.email'),
			),
		),
		array(
			'field'	=> 'u_icq',
			'jevix'	=> true,
			'max'	=> 191,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'icq',
				'label'			=> fx_lang('users.icq'),
			),
		),
		array(
			'field'	=> 'u_skype',
			'jevix'	=> true,
			'max'	=> 191,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'skype',
				'label'			=> fx_lang('users.skype'),
			),
		),
		array(
			'field'	=> 'u_viber',
			'jevix'	=> true,
			'max'	=> 191,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'viber',
				'label'			=> fx_lang('users.viber'),
			),
		),
		array(
			'field'	=> 'u_whatsapp',
			'jevix'	=> true,
			'max'	=> 191,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'whatsapp',
				'label'			=> fx_lang('users.whatsapp'),
			),
		),
		array(
			'field'	=> 'u_telegram',
			'jevix'	=> true,
			'max'	=> 191,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'telegram',
				'label'			=> fx_lang('users.telegram'),
			),
		),
		array(
			'field'	=> 'u_website',
			'label'		=> fx_lang('users.website'),
			'htmlspecialchars'	=> true,
			'max'	=> 191,
			'url'	=> true,
			'params'	=> array(
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_contacts',
				'render_type'	=> 'website',
			),
		),
		array(
			'field'	=> 'u_activities',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'list',
				'label'			=> fx_lang('users.activities'),
			),
		),
		array(
			'field'	=> 'u_interests',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'list',
				'label'			=> fx_lang('users.interests'),
			),
		),
		array(
			'field'	=> 'u_music',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'list',
				'label'			=> fx_lang('users.music'),
			),
		),
		array(
			'field'	=> 'u_films',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'list',
				'label'			=> fx_lang('users.films'),
			),
		),
		array(
			'field'	=> 'u_shows',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'list',
				'label'			=> fx_lang('users.shows'),
			),
		),
		array(
			'field'	=> 'u_books',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'list',
				'label'			=> fx_lang('users.books'),
			),
		),
		array(
			'field'	=> 'u_games',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'list',
				'label'			=> fx_lang('users.games'),
			),
		),
		array(
			'field'	=> 'u_citates',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'list',
				'label'			=> fx_lang('users.citates'),
			),
		),
		array(
			'field'	=> 'u_about',
			'jevix'	=> true,
			'params'	=> array(
				'field_type' 	=> 'textarea',
				'show_validation'	=> false,
				'show_in_filter'=> false,
				'item_position'	=> 'invisible',
				'field_sets'	=> 'field_set_activities',
				'render_type'	=> 'text',
				'label'			=> fx_lang('users.about'),
			),
		),
	);
