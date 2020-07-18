<?php

	function fx_lang($lang_key,$replace_data=array()){
		if(!$lang_key){ return null; }
		$language = \Core\Classes\Language::getInstance();
		if(strpos($lang_key,'.') !== false){
			$language_array = $language->getLanguage();
			$lang_key_array = explode('.',$lang_key);
			if(isset($language_array[$lang_key_array[0]][$lang_key_array[1]])){
				return $language->prepareLanguageData($language_array[$lang_key_array[0]][$lang_key_array[1]],$replace_data);
			}
//			return $language->prepareLanguageData($lang_key_array[1],$replace_data);
		}
		return $lang_key;
	}

