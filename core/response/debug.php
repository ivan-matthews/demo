<?php

	namespace Core\Response;

	class Debug{

		private $default_params = array(
			'time' 		=> '',
			'query' 	=> '',
			'file'		=> '',
			'line'		=> '',
			'class'		=> '',
			'type'		=> '',
			'function'	=> '',
			'args'		=> '',
			'trace' 	=> '',
		);

		private $response;
		private $debug_key;
		private $last_index;

		private $back_trace_key;

		public function __construct($response,$debug_key,$back_trace_key){
			$this->response = $response;
			$this->debug_key = $debug_key;
			$this->back_trace_key = $back_trace_key;

			$this->last_index = $this->getLastArrayKey();
			$this->response->response_data['debug'][$this->debug_key][$this->last_index] = $this->default_params;
		}

		public function setTime($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['time'] = microtime(true)-$value;
			return $this;
		}
		public function setQuery($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['query'] = $value;
			return $this;
		}
		public function setFile($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['file'] = $value;
			return $this;
		}
		public function setLine($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['line'] = $value;
			return $this;
		}
		public function setClass($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['class'] = $value;
			return $this;
		}
		public function setType($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['type'] = $value;
			return $this;
		}
		public function setFunction($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['function'] = $value;
			return $this;
		}
		public function setArgs($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['args'] = $value;
			return $this;
		}

		public function setTrace(array $value){
			foreach($value as $index=>$item){
				if(isset($value[$index]['object'])){ unset($value[$index]['object']); }
				if(fx_equal($index,$this->back_trace_key)){
					$this->response->response_data['debug'][$this->debug_key][$this->last_index]['file'] =
						isset($item['file']) ? $item['file'] : null;
					$this->response->response_data['debug'][$this->debug_key][$this->last_index]['line'] =
						isset($item['line']) ? $item['line'] : null;
					$this->response->response_data['debug'][$this->debug_key][$this->last_index]['class'] =
						isset($item['class']) ? $item['class'] : null;
					$this->response->response_data['debug'][$this->debug_key][$this->last_index]['type'] =
						isset($item['type']) ? $item['type'] : null;
					$this->response->response_data['debug'][$this->debug_key][$this->last_index]['function'] =
						isset($item['function']) ? $item['function'] : null;
					$this->response->response_data['debug'][$this->debug_key][$this->last_index]['args'] =
						isset($item['args']) ? $item['args'] : null;
				}
			}
			$this->response->response_data['debug'][$this->debug_key][$this->last_index]['trace'] = $value;
			return $this;
		}
		public function set($key,$value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index][$key] = $value;
			return $this;
		}
		public function setArray($value){
			$this->response->response_data['debug'][$this->debug_key][$this->last_index] = $value;
			return $this;
		}

		private function getLastArrayKey(){
			$this->response->response_data['debug'][$this->debug_key] =
				(isset($this->response->response_data['debug'][$this->debug_key])
					? $this->response->response_data['debug'][$this->debug_key]
					: array());
			$end = array_keys($this->response->response_data['debug'][$this->debug_key]);
			return !$end?0:max($end)+1;
		}















	}














