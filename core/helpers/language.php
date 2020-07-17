<?php

	function fx_lang($lang_key){
		if(strpos($lang_key,'.') !== false){
			$lang_key_array = explode('.',$lang_key);
			$language = \Core\Classes\Language::getInstance();
			$language_array = $language->getLanguage();
			if(isset($language_array[$lang_key_array[0]][$lang_key_array[1]])){
				return $language_array[$lang_key_array[0]][$lang_key_array[1]];
			}
			return $lang_key_array[1];
		}
		return $lang_key;
	}