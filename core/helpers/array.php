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