<?php

	return array(
		'notices_title'				=> 'Уведомления',
		'all_notices_sorting'		=> 'Все',
		'readed_notices_sorting'	=> 'Прочитанные',
		'unreaded_notices_sorting'	=> 'Новые',
		'notice_manager_name_'		=> 'None',
		'notice_manager_name_0'		=> 'Unknown',
		'notice_manager_name_1'		=> 'Система',
		'notice_manager_name_2'		=> 'Уведомления',
		'notice_manager_name_3'		=> 'Рассылка',
		'follow_to_page'			=> 'посмотреть',
		'notice_content_head'		=> '
			<a href="%user_link%" class="user-link d-block">
				<img class="user-image" src="%user_image%">
				<span class="user-name">%user_name%</span>
			</a>',
		'notice_is_readed'			=> '<i class="fa fa-check text-success" aria-hidden="true"></i> ',
		'new_notice'				=> 'новое',
		'notice_with_sender_title'		=> 'Уведомление с сендером',
		'notice_without_sender_title'	=> 'Уведомление без сендера',
		'notice_with_sender_content'	=> 'Так будет выглядеть уведомление, если вызвать метод 
			<b>Core\Classes\Mail\Notice -> sender(integer user_id)</b>: 
			тоесть контент будет заключен в блок цытаты 
			<pre><code><blockquote>$notice[\'n_content\']</blockquote></code></pre>, и инфа о пользователе, как автора цитаты',
		'notice_without_sender_content'	=> 'Так будет выглядеть уведомление, если не вызывать метод 
			<b>Core\Classes\Mail\Notice -> sender(integer user_id)</b>: тоесть контент будет выведен в блок, как обычный текст',
	);