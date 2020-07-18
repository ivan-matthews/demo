<?php

	function fx_gen($length=64){
		$lower_letters = range('a','z');
		$upper_letters = range('A','Z');
		$number_letters = range('0','9');
		$letters = array_merge($upper_letters,$lower_letters,$number_letters);
		$max = max(array_keys($letters));
		$result = null;
		for($i=0;$i<$length;$i++){
			$result .= $letters[rand(0,$max)];
		}
		return $result;
	}

	function fx_gen_cyr($max_iteration=64){
		$letters = array(
			'й', 'ц', 'у', 'к', 'е', 'н', 'г',
			'ш', 'щ', 'з', 'х', 'ъ', 'ф', 'ы',
			'в', 'а', 'п', 'р', 'о', 'л', 'д',
			'ж', 'э', 'я', 'ч', 'с', 'м', 'и',
			'т', 'ь', 'б', 'ю', 'дз', 'дж',
		);
		$result = null;
		for($i = 0; $i < $max_iteration; $i++){
			$result .= $letters[rand(0, max(array_keys($letters)))];
		}
		return $result;
	}

	function fx_gen_cyr_name($max=32){
		$letters[1] = array(
			'ц','к','н','г','ш','щ','з','х','ф','в','п',
			'р','л','д','ж','ч','с','м','т','б','дз','дж',
		);
		$letters[2] = array(
			'у','е','а','о','э','я','и','ю'/*,'ь','ъ'*/
		);
		$letters[3] = array(
			'цц','кк','нн','гг','шш','щщ','зз','хх','фф','вв',
			'пп','рр','лл','дд','жж','чч','сс','мм','тт','бб'
		);
		$result = null;
		for($i=0;$i<$max;$i++){
			if(is_int($max/2)){
				if(is_int($i/2)){
					$result .= $letters[1][rand(0,max(array_keys($letters[1])))];
				}else{
					$result .= $letters[2][rand(0,max(array_keys($letters[2])))];
				}
			}else{
				if(is_int($i/2)){
					$result .= $letters[2][rand(0,max(array_keys($letters[2])))];
				}else{
					$result .= $letters[1][rand(0,max(array_keys($letters[1])))];
				}
			}
			if($i===1){
				$letters[1] = array_merge($letters[1],array($letters[3][rand(0,max(array_keys($letters[3])))]));
				$letters[2] = array_merge($letters[2],array('ы',));
			}
		}
		return $result;
	}

	function fx_gen_lat($max_iteration=64){
		$result = null;
		$letters[] = range('A','Z');
		$letters = array_merge(...$letters);
		for($start=0;$start<$max_iteration;$start++){
			$result .= $letters[rand(0,max(array_keys($letters)))];
		}
		return mb_strtolower(iconv('CP1251', 'UTF-8',$result));
	}

	function fx_make_captcha($captcha_word,$fontSize=24,$type='png'){
		$letters = preg_split('//u', $captcha_word, null, PREG_SPLIT_NO_EMPTY);
		$textLength = count($letters);
		$captcha_width=($textLength*$fontSize);
		$captcha_height=$fontSize+16;
		$fontXpos = $captcha_width/12;
		$fontYpos = $captcha_height-10;
		$function = "image{$type}";
		if(!function_exists($function)){
			$function = "imagepng";
			$type = "png";
		}
		$img=  imagecreatetruecolor($captcha_width, $captcha_height);
		$bgcolor=imagecolorallocate($img, 225, 225, 225);
		$pixelcolor=imagecolorallocate($img, rand(122,255), rand(122,255), rand(122,255));
		$linecolor=imagecolorallocate($img, rand(122,255), rand(122,255), rand(122,255));
		imagefilledrectangle($img, 0, 0,$captcha_width, $captcha_height, $bgcolor);
		$font = fx_path('public/view/default/webfonts/arialn.ttf');
		for($i=0;$i< rand(5,15);$i++){
			imageline($img,0, rand() % $captcha_height, $captcha_width, rand() % $captcha_height, $linecolor);
		}
		for($i=1;$i< ($captcha_width*$captcha_height)/5;$i++){
			imagesetpixel($img, rand() % $captcha_width, rand() % $captcha_height, $pixelcolor);
		}
		foreach($letters as $k=>$letter){
			$textcolor=imagecolorallocate($img, rand(0,122), rand(0,122), rand(0,122));
			imagettftext($img, $fontSize-rand(-3,3), 0, $fontXpos+($k*($fontSize/1.2)),$fontYpos-rand(-5,5),$textcolor, $font, $letter);
		}
		ob_start();
		$function($img);
		$result = ob_get_contents();
		ob_end_clean();
		return "data:image/{$type};base64," . base64_encode($result);
	}