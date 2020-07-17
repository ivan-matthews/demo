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
		return trim(fx_implode_recursive($glue,$pieces),$glue);
	}

	function fx_implode_recursive(string $glue="",$pieces){
		$result = '';
		if(is_array($pieces)){
			foreach($pieces as $value){
				if(is_object($value)){ continue; }
				if(is_array($value)){
					$result .= fx_implode_recursive($glue,$value);
				}else{
					$value = $value ? $value : 'NULL';
					$result .= "{$value}{$glue}";
				}
			}
		}
		return $result;
	}

	/*
		$input_data = array(
			'some_one'=>'some_body',
			'some_shit'=>'some_fuck'
		);

		unset($_SESSION['var_0'], $_SESSION['var_1'], $_SESSION['var_2'], $_SESSION['var_3']);

		$_SESSION['var_0'] = fx_set_multilevel_array($input_data,0,1,2,3,4,5,6,7,8,9);
		$_SESSION['var_1'] = fx_set_multilevel_array($input_data,'d','e','f','g','h','j','k','l');
		$_SESSION['var_1'] = fx_set_multilevel_array($input_data,'d','e','f','g','h','j','k','o');
		$_SESSION['var_1'] = fx_set_multilevel_array($input_data,'d','e','f','g','h','j','k','p');

		fx_die($_SESSION);
	 */
	function fx_set_multilevel_array($data_to_set,...$keys){
		$output_array = array();
		$search_keys_string = '';
		if($keys){
			foreach($keys as $key){
				$search_keys_string .= "['{$key}']";
			}
		}
		eval('return $output_array'.$search_keys_string.' = $data_to_set;');
		return $output_array;
	}
	/*
		$input_data = array(
			'some_one'=>'some_body',
			'some_shit'=>'some_fuck'
		);
		$ara0 = fx_set_multilevel_array($input_data,'d','e','f','g','h','j','k','p');

		fx_die(
			fx_get_multilevel_array($ara0,'d','e','f','g','h','j','k'),
			$ara0['d']['e']['f']['g']['h']['j']['k']
		);
	*/
	function fx_get_multilevel_array(array $haystack,...$keys){
		$search_keys_string = '';
		if($keys){
			foreach($keys as $key){
				$search_keys_string .= "['{$key}']";
			}
		}
		return eval('return isset($haystack'.$search_keys_string.')?$haystack'.$search_keys_string.':array();');
	}

	function fx_htmlentities($string,$quote_style=null,$charset=null,$double_encode=true){
		$returned_data = array();
		if(is_array($string)){
			foreach($string as $key=>$value){
				if(is_array($value)){
					$returned_data[$key] = fx_htmlentities($value,$quote_style,$charset,$double_encode);
				}else{
					$returned_data[$key] = htmlentities($value,$quote_style,$charset,$double_encode);
				}
			}
		}else{
			$returned_data = htmlentities($string,$quote_style,$charset,$double_encode);
		}
		return $returned_data;
	}

	function fx_htmlspecialchars($string,$flags=ENT_COMPAT,$encoding="UTF-8",$double_encode=true){
		$returned_data = array();
		if(is_array($string)){
			foreach($string as $key=>$value){
				if(is_array($value)){
					$returned_data[$key] = fx_htmlspecialchars($value,$flags,$encoding,$double_encode);
				}else{
					$returned_data[$key] = htmlspecialchars($value,$flags,$encoding,$double_encode);
				}
			}
		}else{
			$returned_data = htmlspecialchars($string,$flags,$encoding,$double_encode);
		}
		return $returned_data;
	}

	function fx_trim($str,$charlist=" \t\n\r\0\x0B"){
		$returned_data = array();
		if(is_array($str)){
			foreach($str as $key=>$value){
				if(is_array($value)){
					$returned_data[$key] = fx_trim($value,$charlist);
				}else{
					$returned_data[$key] = trim($value,$charlist);
				}
			}
		}else{
			$returned_data = trim($str,$charlist);
		}
		return $returned_data;
	}













