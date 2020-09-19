<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Mail\Notice;

	class InsertSimpleNotice202007291143281596062608{

		public function moreNotices(){
			$notify_object = Notice::ready();

			for($i=0;$i<5;$i++){
				$item_id = rand(1,2);

				$notify_object = $notify_object->theme('notify.notices_in_cycle_title')
					->sender(2)
					->manager(rand(Notice::MANAGER_SYSTEM,Notice::MANAGER_MAILING))
					->receiver(1)
					->action('blog','item',$item_id)
					->key("blog.item.{$item_id}")
					->content('notify.notices_in_cycle_content')
					->create();
			}

			$notify_object->send();
			return $this;
		}

		public function noticeWithSenderData(){
			Notice::ready()
				->theme('notify.notice_with_sender_title')
				->sender(1)
				->receiver(1)
				->manager(Notice::MANAGER_SYSTEM)
				->action('users','item',1)
				->content('notify.notice_with_sender_content')
				->create()
				->send();
			return $this;
		}

		public function noticeWithoutSenderData(){
			Notice::ready()
				->theme('notify.notice_without_sender_title')
//				->sender(1)
				->receiver(1)
				->manager(Notice::MANAGER_MAILING)
				->action('users','item',1)
				->content('notify.notice_without_sender_content')
				->create()
				->send();
			return $this;
		}

		public function noticeFromNotifyManager(){
			Notice::ready()
				->theme('notify.notice_from_notify_manager_title')
				->sender(1)
				->receiver(1)
				->manager(Notice::MANAGER_NOTIFY)
				->action('users','item',1)
				->content('notify.notice_from_notify_manager_content')
				->create()
				->send();
			return $this;
		}










	}