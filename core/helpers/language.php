<?php

	function fx_lang($lang_key,$replace_data=array()){
		if(strpos($lang_key,'.') !== false){
			$lang_key_array = explode('.',$lang_key);
			$language = \Core\Classes\Language::getInstance();
			$language_array = $language->getLanguage();
			if(isset($language_array[$lang_key_array[0]][$lang_key_array[1]])){
				return fx_prepare_language_response($language_array[$lang_key_array[0]][$lang_key_array[1]],$replace_data);
			}
			return fx_prepare_language_response($lang_key_array[1],$replace_data);
		}
		return fx_prepare_language_response($lang_key,$replace_data);
	}

	function fx_prepare_language_response($language_value,array $data_to_replace){
		if($data_to_replace){
			$data_keys = array_keys($data_to_replace);
			$data_vals = array_values($data_to_replace);
			return str_replace($data_keys,$data_vals,$language_value);
		}
		return $language_value;
	}