<?php

	function fx_pre(...$data){
		print '<pre>';
		foreach($data as $item){
			$item = empty($item) ? '<strong>EMPTY DATA</strong>' : $item;
			print_r($item);
			print "<br>" . PHP_EOL;
			print str_repeat('-',50);
			print "<br>" . PHP_EOL;
		}
		print '</pre>';
		return null;
	}

	function fx_die(...$data){
		print '<pre>';
		foreach($data as $item){
			$item = empty($item) ? '<strong>EMPTY DATA</strong>' : $item;
			print_r($item);
			print "<br>" . PHP_EOL;
			print str_repeat('-',50);
			print "<br>" . PHP_EOL;
		}
		print '</pre>';
		return die();
	}

	function fx_dump(...$data){
		print '<pre>';
		foreach($data as $item){
			var_dump($item);
			print "<br>" . PHP_EOL;
			print str_repeat('-',50);
			print "<br>" . PHP_EOL;
		}
		print '</pre>';
		return die();
	}

	function fx_get_cpu_usage(){
		try{
			return trim(exec("ps -p " . getmypid() . " -o %cpu"));
		}catch(Exception $e){
			return "NaN";
		}
	}

	function fx_get_cpu_stat($returned_data=true){
		if(!$returned_data){ return null; }
		try{
			exec("pidstat",$result);
			$cpu_stat = preg_replace("#\s+#"," ",$result);
			return $cpu_stat;
		}catch(Exception $e){
			return null;
		}
	}
















