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

	function fx_echo(...$data){
		return fx_print(...$data);
	}

	function fx_print(...$data){
		return print implode(', ',$data);
	}

	function fx_status($variable,$status){
		$variable = (int)$variable;
		if(fx_equal($variable,$status)){
			return true;
		}
		return false;
	}


	function fx_xml_encode($data=false,$tab="\t",$old_tab="",$tag_prefix="item"){
		$result = false;
		if($data){
			if(is_array($data)){
				foreach($data as $key=>$val){
					$empty_var = empty($val);
					$key = !is_numeric($key) ? $key : "{$tag_prefix}";
					$key = str_replace(array(
						' ','/','.',',','\\','=','-',')','(','*','&','^','%','$','#','@','!','\'','"',':',';','?','>','<',
					),'_',$key);
					if(is_array($val)){
						$result .= $tab . "<{$key}>" . ($empty_var?'':PHP_EOL);
						$result .= $old_tab . fx_xml_encode($val,"{$tab}\t",$old_tab);
						$result .= ($empty_var?"NULL":$tab) . "</{$key}>" . PHP_EOL;
					}else
						if(is_object($val)){
							$val = json_decode(json_encode($val),1);
							$result .= $tab . "<{$key}>" . ($empty_var?'':PHP_EOL);
							$result .= $old_tab . fx_xml_encode($val,"{$tab}\t",$old_tab);
							$result .= ($empty_var?"NULL":$tab) . "</{$key}>" . PHP_EOL;
						}
						else{
							$result .= $tab . "<{$key}>";
							$result .= ($empty_var ? "NULL" :"{$val}");
							$result .= "</{$key}>" . PHP_EOL;
						}
				}
			}
		}
		return $result;
	}

	function fx_xml_decode($xml_data,$assoc=false){
		$xml_obj = simplexml_load_string($xml_data);
		if($xml_obj){
			return json_decode(json_encode($xml_obj),$assoc);
		}
		return false;
	}

	function fx_php_encode($data,$t="\t\t",$recursion=false){
		if(!$recursion){
			$dump = "<?php\n\n" .
				"\treturn array(\n";
		}else{
			$dump = "array(\n";
		}
		foreach($data as $key=>$value){
			$prefix = "{$t}";
			if(!is_int($key)){
//				$tabs = 8 - ceil((mb_strlen($key)+3)/4);
				$prefix .= "'{$key}'";
//				$prefix .= str_repeat("\t", $tabs > 0 ? $tabs : 0);
				$prefix .= "	=> ";
			}
			if(is_array($value)){
				$dump .= $prefix;
				$dump .= !empty($value) ? fx_php_encode($value,"{$t}\t",1) : "array(),\n";
			}else
				if(is_object($value)){
					$dump .= $prefix;
					$dump .= !empty($value) ? fx_php_encode($value,"{$t}\t",1) : "array(),\n";
				}else{
					$value = var_export($value, true);
					$dump .= $prefix;
					$dump .= "{$value},\n";
				}
		}
		if(!$recursion){
			$dump .= "\t);\n";
		}else{
			$t = substr($t,0,-1);
			$dump .= "{$t}),\n";
		}
		return $dump;
	}
