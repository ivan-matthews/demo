<?php

	namespace Core\Classes\Response;

	class Error{

		private $default_params = array(
			'number' 	=> '',
			'message' 	=> '',
			'file' 		=> '',
			'line' 		=> '',
			'backtrace' => '',
			'error_msg' => '',
		);

		private $error_key;
		private $response;
		private $last_index;
		private $back_trace_key;

		public function __construct(Response $response,$back_trace_key){
			$this->response = $response;
			$this->back_trace_key = $back_trace_key;
			$this->last_index = $this->getLastArrayKey();
			$this->response->response_data['errors'][$this->error_key][$this->last_index] = $this->default_params;
		}

		private function getLastArrayKey(){
			$this->response->response_data['errors'][$this->error_key] =
				(isset($this->response->response_data['errors'][$this->error_key])
					? $this->response->response_data['errors'][$this->error_key]
					: array());
			$keys = array_keys($this->response->response_data['errors'][$this->error_key]);
			$last_key = end($keys);
			$last_key++;
			return $last_key;
		}



















	}














