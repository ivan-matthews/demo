<?php

	/**
	 * @test	$mail = \Core\Classes\Mail\Mail::set('admin');
	 *			$mail->subject('privet mir!')
	 *				->address('cajopec348@qortu.com','u')
	 *				->from('test.is@my.domain','My name is Test')
	 *				->html('welcome',array('var'=>'privet mir'))
	 *				->send();
	 */

	return array(

		'admin'		=> array(
			'mail_from'			=> 'admin@m.c',
			'mail_from_name'	=> 'Admin MySite',
			'mail_transport'	=> 'mail',						//array(mail,smtp,sendmail)
			'mail_smtp_server'	=> '',
			'mail_smtp_port'	=> null,		//int
			'mail_smtp_auth' 	=> null,		//bool
			'mail_smtp_user'	=> '',
			'mail_smtp_pass'	=> '',
			'mail_smtp_enc'		=> '',
			'mail_default_title'=> 'Welcome!',
			'mail_default_char'	=> 'UTF-8',
			'mail_debug'		=> null,
			'mail_xmailer'		=> ' ',
		),
		'system'	=> array(
			'mail_from'			=> 'some.user.mailbox@gmail.com',		//https://myaccount.google.com/lesssecureapps?pli=1
			'mail_from_name'	=> 'System MySite',
			'mail_transport'	=> 'smtp',						//array(mail,smtp,sendmail)
			'mail_smtp_server'	=> 'smtp.gmail.com',
			'mail_smtp_port'	=> 587,							//int
			'mail_smtp_auth' 	=> 1, 							//bool
			'mail_smtp_user'	=> 'some.user.mailbox@gmail.com',
			'mail_smtp_pass'	=> 'user_password_string',
			'mail_smtp_enc'		=> 'tls',
			'mail_default_title'=> 'Welcome!',
			'mail_default_char'	=> 'UTF-8',
			'mail_debug'		=> null,
			'mail_xmailer'		=> ' ',
		),
		'messages'	=> array(
			'mail_from'			=> 'some.user.mailbox@gmail.com',		//https://myaccount.google.com/lesssecureapps?pli=1
			'mail_from_name'	=> 'Messages MySite',
			'mail_transport'	=> 'smtp',						//array(mail,smtp,sendmail)
			'mail_smtp_server'	=> 'smtp.gmail.com',
			'mail_smtp_port'	=> 587,							//int
			'mail_smtp_auth' 	=> 1, 							//bool
			'mail_smtp_user'	=> 'some.user.mailbox@gmail.com',
			'mail_smtp_pass'	=> 'user_password_string',
			'mail_smtp_enc'		=> 'tls',
			'mail_default_title'=> 'Welcome!',
			'mail_default_char'	=> 'UTF-8',
			'mail_debug'		=> null,
			'mail_xmailer'		=> ' ',
		),
		'notify'	=> array(
			'mail_from'			=> 'some.user.mailbox@gmail.com',		//https://myaccount.google.com/lesssecureapps?pli=1
			'mail_from_name'	=> 'Notify MySite',
			'mail_transport'	=> 'smtp',						//array(mail,smtp,sendmail)
			'mail_smtp_server'	=> 'smtp.gmail.com',
			'mail_smtp_port'	=> 587,							//int
			'mail_smtp_auth' 	=> 1, 							//bool
			'mail_smtp_user'	=> 'some.user.mailbox@gmail.com',
			'mail_smtp_pass'	=> 'user_password_string',
			'mail_smtp_enc'		=> 'tls',
			'mail_default_title'=> 'Welcome!',
			'mail_default_char'	=> 'UTF-8',
			'mail_debug'		=> null,
			'mail_xmailer'		=> ' ',
		),
		'subscribe'	=> array(
			'mail_from'			=> 'some.user.mailbox@gmail.com',		//https://myaccount.google.com/lesssecureapps?pli=1
			'mail_from_name'	=> 'Subscribe MySite',
			'mail_transport'	=> 'smtp',						//array(mail,smtp,sendmail)
			'mail_smtp_server'	=> 'smtp.gmail.com',
			'mail_smtp_port'	=> 587,							//int
			'mail_smtp_auth' 	=> 1, 							//bool
			'mail_smtp_user'	=> 'some.user.mailbox@gmail.com',
			'mail_smtp_pass'	=> 'user_password_string',
			'mail_smtp_enc'		=> 'tls',
			'mail_default_title'=> 'Welcome!',
			'mail_default_char'	=> 'UTF-8',
			'mail_debug'		=> null,
			'mail_xmailer'		=> ' ',
		),
	);