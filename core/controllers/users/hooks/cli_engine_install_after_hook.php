<?php

	namespace Core\Controllers\Users\Hooks;

	use Core\Classes\Console\Interactive;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Database\Database;
	use Core\Console\Engine\Install;

	class Cli_Engine_Install_After_Hook{

		public $install_object;
		public $arguments_list;

		public $user_fields = array(
			'u_first_name'	=> '',
			'u_last_name'	=> '',
			'u_full_name'	=> '',
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
			$this->setFirstName();
			$this->setLastName();
			$this->checkData();
			return $this;
		}

		public function setFirstName(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(Types $types){
					return $types->string(fx_lang('users.cli_enter_first_name'))->color('light_cyan')->get();
				}));
				$this->user_fields['u_first_name'] = $interactive->getDialogString();
			});
			return $this;
		}

		public function setLastName(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(Types $types){
					return $types->string(fx_lang('users.cli_enter_last_name'))->color('light_cyan')->get();
				}));
				$this->user_fields['u_last_name'] = $interactive->getDialogString();
			});
			return $this;
		}

		public function checkData(){
			$this->user_fields['u_full_name'] = "{$this->user_fields['u_first_name']} {$this->user_fields['u_last_name']}";

			Interactive::exec(function(Interactive $interactive){
				Paint::exec(function(Types $types){
					$types->string(fx_lang('users.check_entered_first_name'))->color('yellow')->print()->space();
					$types->string($this->user_fields['u_first_name'])->print()->eol();

					$types->string(fx_lang('users.check_entered_last_name'))->color('yellow')->print()->space();
					$types->string($this->user_fields['u_last_name'])->print()->eol();

					$types->string(fx_lang('users.check_entered_full_name'))->color('yellow')->print()->space();
					$types->string($this->user_fields['u_full_name'])->print()->eol();
				});

				$interactive->create(Paint::exec(function(Types $types){
					return $types->string(fx_lang('users.agree_admin_data_change'))->fon('green')->get();
				}));

				if(fx_equal(mb_strtolower($interactive->getDialogString()),'y')){
					$this->insertOrUpdateUserData();
				}else{
					$this->set();
				}
			});
			return $this;
		}

		public function insertOrUpdateUserData(){
			$admin_account_exists = Database::select('u_id')
				->from('users')
				->where("u_id = 1")
				->get()
				->itemAsArray();

			if($admin_account_exists){
				Database::update('users')
					->field('u_first_name',$this->user_fields['u_first_name'])
					->field('u_last_name',$this->user_fields['u_last_name'])
					->field('u_full_name',$this->user_fields['u_full_name'])
					->where("u_id = 1")
					->get()
					->rows();
			}else{
				Database::insert('users')
					->value('u_first_name',$this->user_fields['u_first_name'])
					->value('u_last_name',$this->user_fields['u_last_name'])
					->value('u_full_name',$this->user_fields['u_full_name'])
					->get()
					->id();
			}

			return $this;
		}







	}














