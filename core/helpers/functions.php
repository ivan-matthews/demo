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