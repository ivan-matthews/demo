<?php

	/*
		use Core\Classes\Mail\Notice;

		Notice::ready()
			->theme('theme')
			->sender(Notice::SENDER_MAILING)
			->receiver(3)
			->status(Notice::STATUS_NOTICE)
			->content('notice content')
			->send();
	--------------------------------------------------------
		use Core\Classes\Mail\Notice;
		use Core\Classes\Mail\Interfaces\Notice as NoticeInterface;

		Notice::ready(function(NoticeInterface $notice){
			$notice->theme('theme')->sender(Notice::SENDER_MAILING)->receiver(21)
				->status(Notice::STATUS_DANGER)->content('hi people!')->send();
		});
	*/

	namespace Core\Classes\Mail;

	use Core\Classes\Database;
	use Core\Classes\Mail\Interfaces\Notice as NoticeInterface;

	class Notice implements NoticeInterface{

		const STATUS_DEFAULT = 1;
		const STATUS_NOTICE = 2;
		const STATUS_WARNING = 3;
		const STATUS_DANGER = 4;

		const SENDER_SYSTEM = -1;
		const SENDER_NOTIFY = -2;
		const SENDER_MAILING = -3;

		private $time;
		/** @var Database\Interfaces\Insert\Insert */
		private $database;
		/** @var Database\Interfaces\Insert\Actions */
		private $send_interface;
		private $status;

		/**
		 * @param null $callback_function
		 * @return NoticeInterface
		 */
		public static function ready($callback_function = null){
			if($callback_function){
				return call_user_func($callback_function,new self());
			}
			return new self();
		}

		public function __construct(){
			$this->time = time();
			$this->connect();
		}
		private function connect(){
			$this->database = Database::insert('notice');
			return $this;
		}
		public function theme($lang_key){
			$this->database->value('theme',$lang_key);
			return $this;
		}
		public function sender($sender_id=null){
			$this->database->value('sender_id',$sender_id);
			return $this;
		}
		public function receiver($receiver_id){
			$this->database->value('receiver_id',$receiver_id);
			return $this;
		}
		public function content($lang_key){
			$this->database->value('content',$lang_key);
			return $this;
		}
		public function attachments(array $attachments){
			$this->database->value('attachments',$attachments);
			return $this;
		}
		public function options($options){
			$this->database->value('options',$options);
			return $this;
		}

		/**
		 * @param int $status
		 * @return $this
		 */
		public function status($status){
			$this->status = $status;
			return $this;
		}
		public function send(){
			$this->setDate()
				->setStatus();
			$this->send_interface = $this->database;
			$result_id = $this->send_interface->get()->id();
			$this->connect();
			return $result_id;
		}
		private function setDate(){
			$this->database->value('date_created',$this->time);
			return $this;
		}
		private function setStatus(){
			$this->database->value('status',$this->status?:self::STATUS_DEFAULT);
			$this->status = null;
			return $this;
		}

















	}














