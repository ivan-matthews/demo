<?php

	if(!function_exists('fx_lang')){
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
	}

	if(!function_exists('fx_create_slug_from_string')){
		function fx_create_slug_from_string($string){
			$language_key = \Core\Classes\Language::getInstance()->getLanguageKey();
			$called_function = "fx_create_slug_from_string_{$language_key}";
			if(function_exists($called_function)){
				return strtolower(call_user_func($called_function,$string));
			}
			return strtolower(fx_create_slug_from_string_ru($string));
		}
	}

	if(!function_exists('fx_create_slug_from_string_ru')){
		function fx_create_slug_from_string_ru($string){
			$replace_array = array(
				'й'	=> 'y', 'ц'	=> 'ts', 'у'=> 'u', 'к'	=> 'k', 'е'	=> 'e', 'н'	=> 'n', 'г'	=> 'g', 'ш'	=> 'sh',
				'щ'	=> 'sh', 'з'=> 'z', 'х'	=> 'h', 'ъ'	=> '', 'ф'	=> 'f', 'ы'	=> 'y', 'в'	=> 'v', 'а'	=> 'a',
				'п'	=> 'p', 'р'	=> 'r', 'о'	=> 'o', 'л'	=> 'l', 'д'	=> 'd', 'ж'	=> 'zh', 'э'=> 'e', 'я'	=> 'ya',
				'ч'	=> 'ch', 'с'=> 's', 'м'	=> 'm', 'и'	=> 'i', 'т'	=> 't', 'ь'	=> '', 'б'	=> 'b', 'ю'	=> 'you',
				'Й'	=> 'y', 'Ц'	=> 'ts', 'У'=> 'u', 'К'	=> 'k', 'Е'	=> 'e', 'Н'	=> 'n', 'Г'	=> 'g', 'Ш'	=> 'sh',
				'Щ'	=> 'sh', 'З'=> 'z', 'Х'	=> 'h', 'Ъ'	=> '', 'Ф'	=> 'f', 'Ы'	=> 'y', 'В'	=> 'v', 'А'	=> 'a',
				'П'	=> 'p', 'Р'	=> 'r', 'О'	=> 'o', 'Л'	=> 'l', 'Д'	=> 'd', 'Ж'	=> 'zh', 'Э'=> 'e', 'Я'	=> 'ya',
				'Ч'	=> 'ch', 'С'=> 's', 'М'	=> 'm', 'И'	=> 'i', 'Т'	=> 't', 'Ь'	=> '', 'Б'	=> 'b', 'Ю'	=> 'you',
				' '	=> '_', '-'	=> '_',
			);
			$array_keys = array_keys($replace_array);
			$array_values = array_values($replace_array);

			$string = str_replace($array_keys,$array_values,$string);

			return preg_replace("#[^a-z0-9\_]#si",'',$string);
		}
	}

	if(!function_exists('fx_create_slug_from_string_en')){
		function fx_create_slug_from_string_en($string){
			$replace_array = array(
				' '	=> '_', '-'	=> '_',
			);
			$array_keys = array_keys($replace_array);
			$array_values = array_values($replace_array);

			$string = str_replace($array_keys,$array_values,$string);

			return preg_replace("#[^a-z0-9\_]#si",'',$string);
		}
	}

