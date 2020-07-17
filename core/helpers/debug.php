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

	function fx_get_cpu_usage(){
		try{
			return trim(exec("ps -p " . getmypid() . " -o %cpu"));
		}catch(Exception $e){
			return "NaN";
		}
	}

	function fx_get_cpu_stat($reverse=false,$first_field='TIME'){
		try{
			exec("pidstat",$result);
			$cpu_stat = preg_replace("#\s+#"," ",$result);
			if(isset($cpu_stat[0]) && isset($cpu_stat[1]) && isset($cpu_stat[2])){
				$index = 0;
				$keys = explode(' ',$cpu_stat[2]);
				unset($cpu_stat[0],$cpu_stat[1],$cpu_stat[2]);
				$keys[0] = $first_field;
				$final_result = array();
				foreach($cpu_stat as $item){
					$values = explode(' ',$item);
					foreach($values as $i=>$value){
						if(!$reverse){
							$final_result[$index][$keys[$i]] = $value;
						}else{
							$final_result[$keys[$i]][] = $value;
						}
					}
					$index++;
				}
				return $final_result;
			}
			return array();
		}catch(Exception $e){
			return array();
		}
	}
















