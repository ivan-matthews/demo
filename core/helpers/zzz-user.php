<?php

	use Core\Classes\Request;
	use Core\Classes\Config;
	use Core\Classes\User;
	use Core\Classes\Form\Validator;
	use Core\Classes\Session;
	use Core\Classes\View;

	if(!function_exists('fx_csrf_equal')){
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
	}
	if(!function_exists('fx_csrf')){
		function fx_csrf(){
			$user = User::getInstance();
			$csrf = $user->getCSRFToken();
			return fx_encode($csrf);
		}
	}
	if(!function_exists('fx_get_csrf_field')){
		function fx_get_csrf_field(){
			$config = Config::getInstance();
			$csrf_token = fx_csrf();
			$field = "<input type=\"hidden\" ";
			$field .= "name=\"{$config->session['csrf_key_name']}\" ";
			$field .= "value=\"{$csrf_token}\"";
			$field .= "/>";
			return $field;
		}
	}
	if(!function_exists('fx_me')){
		function fx_me($my_id,$session_key_id='u_id'){
			$session = Session::getInstance();
			$session_id = (int)$session->get($session_key_id,Session::PREFIX_AUTH);
			$my_id = (int)$my_id;
			if(($session_id && fx_equal($session_id,$my_id))){
				return true;
			}
			return false;
		}
	}
	if(!function_exists('fx_get_full_name')){
		function fx_get_full_name($user_full_name,$gender=3){
			if($user_full_name){
				return $user_full_name;
			}
			return fx_lang("users.users_visible_full_name_{$gender}");
		}
	}
	if(!function_exists('fx_is_online')){
		function fx_is_online($date_log){
			if($date_log < time()){
				return false;
			}
			return true;
		}
	}
	if(!function_exists('fx_online_status')){
		function fx_online_status($date_log){
			if(fx_is_online($date_log)){
				return fx_lang('users.user_is_online');
			}
			return fx_get_date($date_log);
		}
	}
	if(!function_exists('fx_get_date')){
		function fx_get_date($date_timestamp){
			$date = '<span class="date-block">';
			$date .= '<span class="invisible-timestamp hidden">';
			$date .= $date_timestamp;
			$date .= '</span>';

			$date .= '<span class="visible-formatted-date">';
			$date .= date('H:i:s, d m, Y',$date_timestamp);
			$date .= '</span>';
			$date .= '</span>';
			return $date;
		}
	}
	if(!function_exists('fx_get_icon_logged')){
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
	}
	if(!function_exists('fx_avatar')){
		function fx_avatar($avatar,$image_nof_found_key='micro',$gender=3){
			$view = View::getInstance();
			if(!$avatar){
				if(!$gender){
					$gender = 3;
				}
				$config = Config::getInstance();
				$avatar = $config->view['user_avatar'][$gender][$image_nof_found_key];
			}
			return $view->getUploadSiteRoot($avatar);
		}
	}
	if(!function_exists('fx_get_image_src')){
		function fx_get_image_src($image_path,$image_file_version=null,$image_nof_found_key="micro"){
			$view = View::getInstance();
			$image = $view->getUploadSiteRoot($image_path);
			$result_picture_attributes = $image;
			$result_picture_attributes .= ($image_file_version ? "?v={$image_file_version}" : $image_file_version);
			$result_picture_attributes .= '" ';
			$result_picture_attributes .= "onerror=\"indexObj.brokenImage(this, '{$image_nof_found_key}') ";
			return $result_picture_attributes;
		}
	}
	if(!function_exists('fx_print_avatar')){
		function fx_print_avatar($avatar_image,$avatar_key,$version=null,$gender=3,$title=null,$alt=null,$class="user-avatar"){
			$version = !$version ? '': "?v={$version}";
			$alt = $alt ?: $title ?: 'image';
			$avatar_image = fx_avatar($avatar_image,$avatar_key,$gender);
			return print "<img onerror=\"indexObj.brokenImage(this,'{$avatar_key}')\" class=\"{$class}\" src=\"{$avatar_image}{$version}\" title=\"{$title}\" alt=\"{$alt}\">";
		}
	}
	if(!function_exists('fx_logged')){
		function fx_logged(){
			if(User::getInstance()->logged()){
				return true;
			}
			return false;
		}
	}