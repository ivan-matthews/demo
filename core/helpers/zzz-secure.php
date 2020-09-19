<?php

	use Core\Classes\Config;

	if(!function_exists('fx_encode')){
		function fx_encode($data,$secret_key=null){
			$config = Config::getInstance()->secure;
			return md5($config['secret_word'] .
				sha1($data . md5($secret_key) . $config['secret_word']) .
				md5($secret_key . sha1($config['secret_word']) . $data) .
				sha1($config['secret_word'] . md5($data) . $secret_key)
			);
		}
	}
	if(!function_exists('fx_encryption')){
		function fx_encryption($plaintext,$key=false){
			$config = Config::getInstance()->secure['cryption'];
			$key	= $key ? $key : $config['cryption_key'];
			$ivlen 			= openssl_cipher_iv_length($cipher = $config['openssl_cipher']);
			$iv				= openssl_random_pseudo_bytes($ivlen);
			$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
			$hmac 			= hash_hmac($config['cryption_method'], $ciphertext_raw, $key, $as_binary = true);
			$ciphertext 	= base64_encode($iv . $hmac . $ciphertext_raw);
			return $ciphertext;
		}
	}
	if(!function_exists('fx_decryption')){
		function fx_decryption($ciphertext,$key=false){
			$config = Config::getInstance()->secure['cryption'];
			$key	= $key ? $key : $config['cryption_key'];
			$c 				= base64_decode($ciphertext);
			$ivlen 			= openssl_cipher_iv_length($cipher=$config['openssl_cipher']);
			$iv 			= substr($c, 0, $ivlen);
			$hmac 			= substr($c, $ivlen, $sha2len=32);
			$ciphertext_raw = substr($c, $ivlen+$sha2len);
			$plaintext 		= openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
			$calcmac 		= hash_hmac($config['cryption_method'], $ciphertext_raw, $key, $as_binary=true);
			if(hash_equals($hmac, $calcmac)){
				return $plaintext;
			}
			return false;
		}
	}