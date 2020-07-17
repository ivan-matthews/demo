<?php

	function fx_reverse_array(array $array){
		$result = array();
		foreach($array as $key=>$value){
			foreach($value as $index=>$item){
				$result[$index][$key] = $item;
			}
		}
		return $result;
	}

	function fx_reverse_array_callback(array $array,callable $callback){
		$result = array();
		foreach($array as $key=>$value){
			foreach($value as $index=>$item){
				$callback($index,$key,$item);
				$result[$index][$key] = $item;
			}
		}
		return $result;
	}

	function fx_array_callback(array $data_array, callable $callback){
		$result = array();
		foreach($data_array as $key=>$item){
			$callback($key,$item);
			$result[$key] = $item;
		}
		return $result;
	}
	/*
		fx_die(fx_array_callback_recursive(array(
			'f'	=> 'sd',
			's'	=> json_decode(json_encode(array('f'=>'sdsd'))),
			'ds'=> Response::getInstance()
		),function($key,$val){
			if(is_object($val) && !$val instanceof stdClass){
				unset($key);
				return null;
			}
			return $val;
		}));
	*/
	function fx_array_callback_recursive(array $data_array, callable $callback){
		$result = array();
		foreach($data_array as $key=>$item){
			if(is_array($item)){
				$result[$key] = fx_array_callback_recursive($item,$callback);
			}else{
				$response = $callback($key,$item);
				if($response){
					$result[$key] = $response;
				}
			}
		}
		return $result;
	}

	function fx_implode(string $glue="",$pieces){
		$result = '';
		if(is_array($pieces)){
			foreach($pieces as $value){
				if(is_object($value)){ continue; }
				if(is_array($value)){
					$result .= fx_implode($glue,$value);
				}else{
					$result .= "{$value}{$glue}";
				}
			}
		}
		return trim($result,$glue);
	}

	/*
		 $input_array = array(
			'a'=>array(
				'b'=>array(
					'c'=>array(
						'd'=>array(
							'e'=>array(
								'f'=>array(
									'ok'
								)
							)
						)
					)
				)
			)
		);
		fx_pre(
			fx_search_keys_in_array($input_array,'a','b','c','d','e','f','0'),
			fx_search_keys_in_array($input_array,'a','b','c','d','e','f'),
			fx_search_keys_in_array($input_array,'a','b','c','d','e','f','i'),
			fx_search_keys_in_array($input_array)
		);
	 */
	function fx_search_keys_in_array($array,...$keys){
		$search_keys_string = '';
		if($keys){
			foreach($keys as $key){
				$search_keys_string .= "['{$key}']";
			}
		}
		return eval('return isset($array'.$search_keys_string.')?$array'.$search_keys_string.':array();');
	}
