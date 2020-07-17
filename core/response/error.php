<?php

	namespace Core\Response;

	class Error{

		private $default_params = array(
			'number' 	=> '',
			'message' 	=> '',
			'file' 		=> '',
			'line' 		=> '',
			'backtrace' => '',
			'error_msg' => '',
		);

		private $response;
		private $last_index;
		private $back_trace_key;

		public function __construct($response,$back_trace_key){
			$this->response = $response;
			$this->back_trace_key = $back_trace_key;
			$this->last_index = $this->getLastArrayKey();
			$this->response->response_data['errors'][$this->last_index] = $this->default_params;
		}

		private function getLastArrayKey(){
			$this->response->response_data['errors'] =
				(isset($this->response->response_data['errors'])
					? $this->response->response_data['errors']
					: array());
			$end = array_keys($this->response->response_data['errors']);
			return !$end?0:max($end)+1;
		}


















	}














