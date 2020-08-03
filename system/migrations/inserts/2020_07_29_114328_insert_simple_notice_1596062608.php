<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Mail\Notice;

	class InsertSimpleNotice202007291143281596062608{

		public function noticeWithSenderData(){
			Notice::ready()
				->theme('notify.notice_with_sender_title')
				->action('users','item',1)
				->sender(1)
				->receiver(1)
				->content('notify.notice_with_sender_content')
				->send();
			return $this;
		}

		public function noticeWithoutSenderData(){
			Notice::ready()
				->theme('notify.notice_without_sender_title')
				->action('users','item',1)
//				->sender(1)
				->receiver(1)
				->content('notify.notice_without_sender_content')
				->send();
			return $this;
		}











	}