<?php

	function fx_arr($data,$default_type='array'){
		if(is_array($data)){
			return $data;
		}
		if(is_object($data)){
			return json_decode(json_encode($data),1);
		}
		if(fx_is_json($data)){
			return json_decode($data,1);
		}
		settype($data,$default_type);
		return $data;
	}

	function fx_is_json($str){
		if(!is_string($str)){ return false; }
		json_decode($str);
		if(!json_last_error()){
			return true;
		}
		return false;
	}

	function fx_equal($a,$b){
		if($a === $b){
			return true;
		}
		return false;
	}

	function fx_echo($data){
		return fx_print($data);
	}

	function fx_print($data){
		return print $data;
	}
