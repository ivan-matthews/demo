<?php

	/*
		use Core\Classes\Mail\Notice;

		Notice::ready()
			->theme('theme')
			->sender(2)		// user_id
			->receiver(3)	// users_id
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

	--------------------------------------------------------

		$notify = \Core\Classes\Mail\Notice::ready();
		for($i=0;$i<100;$i++){
			$notify = $notify->theme('hi');
			$notify = $notify->action('users','index','online','dn');
			$notify = $notify->sender(rand(2,140));
			$notify = $notify->receiver(1);
			$notify = $notify->content('privet ;)');
			$notify = $notify->create();
		}
		$notify->send();
	*/

	namespace Core\Classes\Mail;

	use Core\Classes\Database\Database;
	use Core\Classes\Database\Interfaces\Insert\Update;
	use Core\Classes\Kernel;
	use Core\Classes\Mail\Interfaces\Notice as NoticeInterface;

	class Notice implements NoticeInterface{

		const STATUS_UNREAD = 1;
		const STATUS_READED = 2;
		const STATUS_DELETED = 3;
		const STATUS_INACTIVE = 4;

		const MANAGER_SYSTEM = 1;
		const MANAGER_NOTIFY = 2;
		const MANAGER_MAILING = 3;

		private $time;
		/** @var \Core\Classes\Database\Interfaces\Insert\Insert */
		private $database;
		/** @var \Core\Classes\Database\Interfaces\Insert\Actions */
		private $send_interface;
		/** @var Update */
		private $update_interface;
		private $status;

		private $sender;
		private $content;
		private $content_replace_data;
		private $theme;
		private $theme_replace_data;

		private $notify_ready = null;

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
		public function theme($lang_key,$replace_data=array()){
			$this->theme = $lang_key;
			$this->theme_replace_data = $replace_data;

			$this->database->value('n_theme',$lang_key);
			$this->database->value('n_theme_data_to_replace',$replace_data);
			return $this;
		}
		public function sender($sender_id=null){
			$this->sender = $sender_id;

			$this->database->value('n_sender_id',$sender_id);
			return $this;
		}
		public function manager($manager_id=self::MANAGER_SYSTEM){
			$this->database->value('n_manager_id',$manager_id);
			return $this;
		}
		public function receiver($receiver_id){
			$this->database->value('n_receiver_id',$receiver_id);
			return $this;
		}
		public function content($lang_key,$replace_data=array()){
			if(mb_strlen($lang_key) > 191){
				$lang_key = fx_crop_string($lang_key,191,null);
			}
			$this->content = $lang_key;
			$this->content_replace_data = $replace_data;

			$this->database->value('n_content',$lang_key);
			$this->database->value('n_content_data_to_replace',$replace_data);
			return $this;
		}
		public function attachments(array $attachments){
			$this->database->value('n_attachments',$attachments);
			return $this;
		}
		public function options($options){
			$this->database->value('n_options',$options);
			return $this;
		}
		public function action($controller=null,$action=null,...$params){
			if(!$controller && !$action && !$params){ return $this; }
			$this->database->value('n_action',array($controller,$action,$params));
			return $this;
		}
		public function key($unique_key){
			$this->database->value('n_unique',md5($unique_key));
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

		public function create(){
			$this->notify_ready = true;
			$this->setDate()
				->setStatus();
			return $this;
		}

		public function send(){
			$result_id = null;
			if($this->notify_ready){
				$this->update();
				$this->send_interface = $this->database;
				$result_id = $this->send_interface->get()->id();
			}
			$this->connect();
			return $result_id;
		}
		private function setDate(){
			$this->database->value('n_date_created',$this->time);
			return $this;
		}
		private function setStatus(){
			$this->database->value('n_status',$this->status?:self::STATUS_UNREAD);
			$this->status = null;
			return $this;
		}

		private function update(){
			$this->update_interface = $this->database;
			$this->update_interface->updateQuery('n_unique_count',"n_unique_count+1");
			$this->update_interface->update('n_sender_id',$this->sender);
			$this->update_interface->update('n_content',$this->content);
			$this->update_interface->update('n_theme',$this->theme);
			$this->update_interface->update('n_theme_data_to_replace',$this->theme_replace_data);
			$this->update_interface->update('n_content_data_to_replace',$this->content_replace_data);
			$this->update_interface->update('n_date_updated',null);
			$this->update_interface->update('n_date_created',time());
			$this->update_interface->update('n_status',Kernel::STATUS_ACTIVE);
			return $this;
		}
















	}














