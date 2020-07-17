<?php

	namespace Core\Classes\Response;

	class Session_Message{

		private $default_params = array(
			'alert_status'	=> 'success',
			'alert_icon'	=> '',
			'head_text'		=> '',
			'body_text'		=> '',
			'date_expired'	=> '',
			'date_created'	=> '',
		);

		private $session_message;
		private $response;
		private $time;

		public function __construct(Response $response,$session_message){
			$this->response = $response;
			$this->session_message = $session_message;
			$this->time = time();
			$this->response->response_data['response_data']['session_message'][$this->session_message] = $this->default_params;
			$this->setCreatedDate($this->time);
			$this->setExpiredDate(5);
		}

		public function set($key,$value){
			$this->response->response_data['response_data']['session_message'][$this->session_message][$key] = $value;
			return $this;
		}

		public function setAlertStatus($value){
			$this->response->response_data['response_data']['session_message'][$this->session_message]['alert_status'] = $value;
			return $this;
		}

		public function setAlertIcon($value){
			$this->response->response_data['response_data']['session_message'][$this->session_message]['alert_icon'] = $value;
			return $this;
		}

		public function setHeadText($value){
			$this->response->response_data['response_data']['session_message'][$this->session_message]['head_text'] = $value;
			return $this;
		}

		public function setBodyText($value){
			$this->response->response_data['response_data']['session_message'][$this->session_message]['body_text'] = $value;
			return $this;
		}

		public function setExpiredDate($value){
			$this->response->response_data['response_data']['session_message'][$this->session_message]['date_expired'] = $this->time+$value;
			return $this;
		}

		public function setCreatedDate($value){
			$this->response->response_data['response_data']['session_message'][$this->session_message]['date_created'] = $value;
			return $this;
		}

		public function setArray(array $session_message_data){
			$this->response->response_data['response_data']['session_message'][$this->session_message] = $session_message_data;
		}




















	}














