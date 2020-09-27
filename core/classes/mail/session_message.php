<?php

	namespace Core\Classes\Mail;

	use Core\Classes\Session;
	use Core\Classes\Mail\Interfaces\Session_Message as SessionMessage;

	class Session_Message implements SessionMessage{

		protected $session;
		protected $session_message_default_config = array(
			'value'				=> '',
			'head'				=> '',
			'unlink_link'		=> '',
			'original_key'		=> '',
			'preview_image'		=> null,
			'removable'			=> true,	// <a>
			'viewed'			=> null,	// ???
			'date_created'		=> 0,
			'expired_time'		=> null,	// !!!
			'icon_class'		=> 'far fa-grin-alt',
			'icon_block_class'	=> 'text-success',
			'header_class'		=> 'p-1',
			'value_class'		=> 'p-2',
			'message_class'		=> '',
			'disabled_pages'	=> array(),
			'enabled_pages'		=> array(),
			'disabled_groups'	=> array(),
			'enabled_groups'	=> array(),
		);
		protected $key;
		protected $time;

		public function __construct($key){
			$this->session = Session::getInstance();
			$this->key = $key;
			$this->time = time();
			$this->session_message_default_config['date_created'] = $this->time;
			$this->session_message_default_config['original_key'] = $this->key;
			$this->session_message_default_config['unlink_link'] = fx_get_url('home','unlink_session_message',$this->key);
		}

		/**
		 * @param $key
		 * @return SessionMessage
		 */
		public static function set($key){
			return new self($key);
		}

		public function send(){
			$this->session->setSessionMessageArray($this->key,$this->session_message_default_config);
			return true;
		}

		public function setArray(array $array_data){
			foreach($array_data as $key=>$value){
				$this->session_message_default_config[$key] = $value;
			}
			return $this;
		}

		public function unlink_link($value){
				$this->session_message_default_config[__FUNCTION__] = $value;
				return $this;
		}
		public function original_key($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function preview_image($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function removable($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function icon_class($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function icon_block_class($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function message_class($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function header_class($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function value_class($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function value($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function head($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function date_created($value){
			$this->session_message_default_config[__FUNCTION__] = $value;
			return $this;
		}
		public function expired_time($value){
			$this->session_message_default_config[__FUNCTION__] = $this->time+$value;
			return $this;
		}

		public function disabled_pages($controller,...$actions){
			$this->session_message_default_config[__FUNCTION__][$controller] = $actions;
			return $this;
		}
		public function enabled_pages($controller,...$actions){
			$this->session_message_default_config[__FUNCTION__][$controller] = $actions;
			return $this;
		}
		public function disabled_groups(...$groups_list){
			$this->session_message_default_config[__FUNCTION__] = $groups_list;
			return $this;
		}
		public function enabled_groups(...$groups_list){
			$this->session_message_default_config[__FUNCTION__] = $groups_list;
			return $this;
		}




















	}














