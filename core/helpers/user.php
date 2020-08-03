<?php

	use Core\Classes\Request;
	use Core\Classes\Config;
	use Core\Classes\User;
	use Core\Classes\Form\Validator;
	use Core\Classes\Session;
	use Core\Classes\View;

	function fx_csrf_equal($csrf_field_name='csrf'){
		$request = Request::getInstance();
		$request_csrf = $request->get($csrf_field_name);
		if(!$request_csrf){
			return Validator::CSRF_TOKEN_NOT_FOUND;
		}
		if(fx_equal(fx_csrf(),$request_csrf)){
			return Validator::CSRF_TOKEN_EQUAL;
		}
		return Validator::CSRF_TOKEN_NOT_EQUAL;
	}

	function fx_csrf(){
		$user = User::getInstance();
		$csrf = $user->getCSRFToken();
		return fx_encode($csrf);
	}

	function fx_get_csrf_field(){
		$config = Config::getInstance();
		$csrf_token = fx_csrf();
		$field = "<input type=\"hidden\" ";
		$field .= "name=\"{$config->session['csrf_key_name']}\" ";
		$field .= "value=\"{$csrf_token}\"";
		$field .= "/>";
		return $field;
	}

	function fx_me($my_id,$session_key_id='u_id'){
		$session = Session::getInstance();
		$session_id = (int)$session->get($session_key_id,Session::PREFIX_AUTH);
		$my_id = (int)$my_id;
		if(($session_id && fx_equal($session_id,$my_id)) || fx_equal($session_id,1) /* admin account (debug)*/){
			return true;
		}
		return false;
	}

	function fx_get_full_name($user_full_name,$gender=3){
		if($user_full_name){
			return $user_full_name;
		}
		return fx_lang("users.users_visible_full_name_{$gender}");
	}

	function fx_is_online($date_log){
		if($date_log < time()){
			return false;
		}
		return true;
	}

	function fx_online_status($date_log){
		if(fx_is_online($date_log)){
			return fx_lang('users.user_is_online');
		}
		return fx_get_date($date_log);
	}

	function fx_get_date($date_timestamp){
		$date = '<span class="date-block">';
		$date .= '<span class="invisible-timestamp">';
		$date .= $date_timestamp;
		$date .= '</span>';

		$date .= '<span class="visible-formatted-date">';
		$date .= date('H:i:s, d m, Y',$date_timestamp);
		$date .= '</span>';
		$date .= '</span>';
		return $date;
	}

	function fx_get_icon_logged($user_log_type){
		$icons = array(
			User::LOGGED_APPLE		=> '<i class="fab apple fa-apple" aria-hidden="true"></i>',
			User::LOGGED_ANDROID	=> '<i class="fab android fa-android" aria-hidden="true"></i>',
			User::LOGGED_LINUX		=> '<i class="fab linux fa-linux" aria-hidden="true"></i>',
			User::LOGGED_WINDOWS	=> '<i class="fab windows fa-windows" aria-hidden="true"></i>',

			User::LOGGED_DESKTOP	=> '<i class="fas desktop fa-desktop" aria-hidden="true"></i>',
			User::LOGGED_TABLET		=> '<i class="fas tablet fa-tablet-alt" aria-hidden="true"></i>',
			User::LOGGED_MOBILE		=> '<i class="fas mobile fa-mobile-alt" aria-hidden="true"></i>',

			User::LOGGED_DEFAULT	=> '<i class="far circle fa-circle" aria-hidden="true"></i>',
		);
		if(isset($icons[$user_log_type])){
			return $icons[$user_log_type];
		}
		return $icons[User::LOGGED_DEFAULT];
	}

	function fx_avatar($avatar,$image_nof_found_key='micro',$gender=3){
		$view = View::getInstance();
		if(!$avatar){
			$config = Config::getInstance();
			$avatar = $config->view['user_avatar'][$gender][$image_nof_found_key];
		}
		return $view->getUploadSiteRoot($avatar);
	}

	function fx_print_avatar($avatar_image,$avatar_key,$version=null,$gender=3,$title=null,$alt=null,$class="user-avatar"){
		$version = !$version ? '': "?v={$version}";
		$alt = $alt ?: $title ?: 'image';
		$avatar_image = fx_avatar($avatar_image,$avatar_key,$gender);
		return print "<img class=\"{$class}\" src=\"{$avatar_image}{$version}\" title=\"{$title}\" alt=\"{$alt}\">";
	}
