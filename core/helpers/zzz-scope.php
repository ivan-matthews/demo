<?php

	if(!function_exists('fx_arr')){
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
	}
	if(!function_exists('fx_obj')){
		function fx_obj($data,$default_type='object'){
			if(is_array($data)){
				return $data;
			}
			if(is_object($data)){
				return json_decode(json_encode($data));
			}
			if(fx_is_json($data)){
				return json_decode($data);
			}
			settype($data,$default_type);
			return $data;
		}
	}
	if(!function_exists('fx_is_json')){
		function fx_is_json($str){
			if(!is_string($str)){ return false; }
			json_decode($str);
			if(!json_last_error()){
				return true;
			}
			return false;
		}
	}
	if(!function_exists('fx_equal')){
		function fx_equal($a,$b){
			if($a === $b){
				return true;
			}
			return false;
		}
	}
	if(!function_exists('fx_echo')){
		function fx_echo(...$data){
			return fx_print(...$data);
		}
	}
	if(!function_exists('fx_print')){
		function fx_print(...$data){
			return print implode(', ',$data);
		}
	}
	if(!function_exists('fx_status')){
		function fx_status($variable,$status){
			$variable = (int)$variable;
			if(fx_equal($variable,$status)){
				return true;
			}
			return false;
		}
	}
	if(!function_exists('fx_json_encode')){
		function fx_json_encode($data,$options=JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES){
			return json_encode($data,$options);
		}
	}
	if(!function_exists('fx_array2xml')){
		function fx_array2xml(array $input_data, $pretty_output = true,$root_tag='root',$numeric_indexes="item",$empty_value="NULL",$space2tab=true){
			$XMLObject = new SimpleXMLElement("<{$root_tag}/>");
			/**
			 * @param callable $self_function
			 * @param array $input_data
			 * @param \SimpleXMLElement $XMLObject
			 * @param $numeric_indexes
			 * @param $empty_value
			 * @return mixed
			 */
			$create_xml = function(callable $self_function,array $input_data,$XMLObject,$numeric_indexes,$empty_value){
				foreach($input_data as $key=>$value){
					if(is_numeric($key)){ $key = "{$numeric_indexes}{$key}";}
					$key = str_replace(array(
						' ','+','/','.',',','\\','=','-',')','(','*','&','^','%','$','#','@','!','\'','"',':',';','?','>','<',
					),'_',$key);
					if(empty($value)){ $value = $empty_value; }
					if(is_array($value)){
						$self_function($self_function,$value,$XMLObject->addChild($key),$numeric_indexes,$empty_value);
					}else{
						$XMLObject->addChild($key,htmlspecialchars(trim($value)));
					}
				}
				return $XMLObject;
			};
			$create_xml($create_xml,$input_data,$XMLObject,$numeric_indexes,$empty_value);
			if($pretty_output){
				$DOMDocumentObject = new \DOMDocument('1.0');
				$DOMDocumentObject->preserveWhiteSpace = false;
				$DOMDocumentObject->formatOutput = true;
				$DOMDocumentObject->loadXML($XMLObject->asXML());
				if($space2tab){
					return str_replace( "  ","\t",$DOMDocumentObject->saveXML());
				}
				return $DOMDocumentObject->saveXML();
			}
			return $XMLObject->asXML();
		}
	}
	if(!function_exists('fx_xml_encode')){
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
							$result .= $old_tab . fx_xml_encode($val,"{$tab}{$tab}",$old_tab);
							$result .= ($empty_var?"NULL":$tab) . "</{$key}>" . PHP_EOL;
						}else
							if(is_object($val)){
								$val = json_decode(json_encode($val),1);
								$result .= $tab . "<{$key}>" . ($empty_var?'':PHP_EOL);
								$result .= $old_tab . fx_xml_encode($val,"{$tab}{$tab}",$old_tab);
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
	}
	if(!function_exists('fx_xml_decode')){
		function fx_xml_decode($xml_data,$assoc=false){
			$xml_obj = simplexml_load_string($xml_data);
			if($xml_obj){
				return json_decode(json_encode($xml_obj),$assoc);
			}
			return false;
		}
	}
	if(!function_exists('fx_php_encode')){
		function fx_php_encode($data,$t="\t\t",$recursion=false, $with_php_tag_before=true){
			$dump = '';
			if(!$recursion){
				if($with_php_tag_before){
					$dump .= "<?php\n\n";
				}
				$dump .= "\treturn array(\n";
			}else{
				$dump .= "array(\n";
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
					$dump .= !empty($value) ? fx_php_encode($value,"{$t}\t",1,$with_php_tag_before) : "array(),\n";
				}else
					if(is_object($value)){
						$dump .= $prefix;
						$dump .= !empty($value) ? fx_php_encode($value,"{$t}\t",1,$with_php_tag_before) : "array(),\n";
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
	}

	if(!function_exists('fx_php_decode')){
		function fx_php_decode(string $php_array){
			return eval($php_array);
		}
	}
