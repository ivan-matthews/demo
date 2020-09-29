<?php

	namespace Core\Controllers\Auth\Hooks;

	use Core\Classes\Console\Interactive;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Database\Database;
	use Core\Console\Engine\Install;

	class Cli_Engine_Install_After_Hook{

		public $install_object;
		public $arguments_list;

		public $auth_fields = array(
			'a_login'			=> '',
			'a_password'		=> '',
			'a_enc_password'	=> '',
		);
		public $auth_raw_fields = array(
			'login'			=> '',
			'password'		=> '',
		);

		public function __construct(){

		}

		public function run(Install $install,...$arguments_list){
			$this->install_object = $install;
			$this->arguments_list = $arguments_list;

			$this->set();
			return true;
		}

		public function set(){
			$this->setLogin();
			$this->setPassword();
			$this->checkData();
			return $this;
		}

		public function setLogin(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(Types $types){
					return $types->string(fx_lang('auth.login_field_title'))->color('light_cyan')->get();
				}));
				$login = $interactive->getDialogString();
				$this->auth_raw_fields['login'] = $login;
				$this->auth_fields['a_login'] = $login;
			});
			return $this;
		}

		public function setPassword(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(Types $types){
					return $types->string(fx_lang('auth.password_field_title'))->color('light_cyan')->get();
				}));
				$password = $interactive->getDialogString();
				$this->auth_raw_fields['password'] = $password;
				$this->auth_fields['a_password'] = fx_encode($password);
				$this->auth_fields['a_enc_password'] = fx_encryption($password);
			});
			return $this;
		}

		public function checkData(){
			Interactive::exec(function(Interactive $interactive){
				Paint::exec(function(Types $types){
					$types->string(fx_lang('auth.cli_check_data_login'))->color('yellow')->print()->space();
					$types->string(" {$this->auth_raw_fields['login']}")->print()->eol();
					$types->string(fx_lang('auth.cli_check_data_password'))->color('yellow')->print()->space();
					$types->string(" {$this->auth_raw_fields['password']}")->print()->eol();
				});
				$interactive->create(Paint::exec(function(Types $types){
					return $types->string(fx_lang('auth.agree_admin_account_change'))->fon('green')->get();
				}));
				if(!fx_equal(mb_strtolower($interactive->getDialogString()),'y')){
					$this->set();
				}else{
					$this->insertOrUpdateAuthInfo();
				}
			});
			return $this;
		}

		public function insertOrUpdateAuthInfo(){
			$admin_account = Database::select('a_id')
				->from('auth')
				->where("a_id = 1")
				->limit(1)
				->get()
				->itemAsArray();
			if($admin_account){
				Database::update('auth')
					->field('a_login',$this->auth_fields['a_login'])
					->field('a_password',$this->auth_fields['a_password'])
					->field('a_enc_password',$this->auth_fields['a_enc_password'])
					->field('a_bookmark',fx_encode($this->auth_raw_fields['login'].$this->auth_raw_fields['password']))
					->where("a_id = 1")
					->get()
					->rows();
			}else{
				$users_groups = Database::select('ug_id')
					->from('user_groups')
					->where("ug_default=0")
					->get()
					->allAsArray();
				$users_groups_values = array();
				if($users_groups){
					foreach($users_groups as $group){
						$users_groups_values[] = $group['ug_id'];
					}
				}
				Database::insert('auth')
					->value('a_login',$this->auth_fields['a_login'])
					->value('a_password',$this->auth_fields['a_password'])
					->value('a_enc_password',$this->auth_fields['a_enc_password'])
					->value('a_groups',$users_groups_values)
					->value('a_bookmark',fx_encode($this->auth_raw_fields['login'].$this->auth_raw_fields['password']))
					->get()
					->id();
			}

			return $this;
		}












	}














