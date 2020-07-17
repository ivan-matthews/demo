<?php

	function fx_gen($length){
		$lower_letters = range('a','z');
		$upper_letters = range('A','Z');
		$number_letters = range('0','9');
		$letters = array_merge($upper_letters,$lower_letters,$number_letters);
		$max = max(array_keys($letters));
		$result = null;
		for($i=0;$i<=$length;$i++){
			$result .= $letters[rand(0,$max)];
		}
		return $result;
	}
