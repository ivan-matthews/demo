<?php

	function fx_mb_ucfirst($str){
		if(is_string($str)){
			$first = mb_substr($str,0,1);
			$last = mb_substr($str,1);
			return mb_strtoupper($first) . $last;
		}
		return false;
	}

	function fx_mb_lcfirst($str){
		if(is_string($str)){
			$first = mb_substr($str,0,1);
			$last = mb_substr($str,1);
			return mb_strtolower($first) . $last;
		}
		return false;
	}
