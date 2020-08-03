<?php

	namespace System\Cron_Tasks\Users;

	use Core\Classes\Cache\Cache;
	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Classes\User;

	class Add_New_Bot{

		public $geo_data;
		public $login;
		public $password;
		public $first_name;
		public $last_name;
		public $full_name;
		public $online_time;

		public $params;
		public $auth_id;
		public $user_id;

		public function __construct(){
			$this->password		= 'Qwerty12345^';
			$this->geo_data 	= $this->fx_get_geo();
			$this->login 		= fx_gen_lat(rand(15,30)) . '@' . fx_gen_lat(rand(15,30)) . '.'. fx_gen_lat(rand(2,5));
			$this->first_name 	= fx_mb_ucfirst(fx_gen_cyr_name(rand(4,10)));
			$this->last_name 	= fx_mb_ucfirst(fx_gen_cyr_name(rand(4,10)));
			$this->full_name 	= "{$this->first_name} {$this->last_name}";
			$this->online_time 	= 900+time();
		}

		public function fx_get_geo(){
			$country_id = rand(1,237);
			$geo_data = Database::select()
				->from('geo_cities')
				->where("gc_country_id={$country_id}")
				->order('rand()')->sort()->limit(1)
				->get()->itemAsArray();
			if(!$geo_data['gc_country_id']){
				return $this->fx_get_geo();
			}
			return $geo_data;
		}

		/**
		 * @param $params 'cron_task' item array from DB
		 * @return string | boolean
		 */
		public function execute($params){
			$this->params = $params;
			$this->makeAuthId();
			$this->makeUserId();
			return true;
		}

		public function makeAuthId(){
			$this->auth_id = Database::insert('auth')
				->value('a_login',$this->login)
				->value('a_password',fx_encode('Qwerty12345^'))
				->value('a_enc_password',fx_encryption('Qwerty12345^'))
				->value('a_groups',array(2))
				->value('a_bookmark',fx_encode($this->login.'Qwerty12345^'))
				->value('a_date_activate',time())
				->value('a_status',Kernel::STATUS_ACTIVE)
				->value('a_verify_token',trim(base64_encode(fx_encode($this->login.$this->login.'Qwerty12345^')),'='))
				->value('a_date_created',time())
				->update('a_date_updated',time())
				->get()
				->id();

			return $this;
		}

		public function makeUserId(){
			Database::insert('users')
				->value('u_auth_id',$this->auth_id)
				->value('u_first_name',$this->first_name)
				->value('u_last_name',$this->last_name)
				->value('u_full_name',$this->full_name)
				->value('u_gender',rand(User::GENDER_MALE,User::GENDER_NONE))
				->value('u_country_id',$this->geo_data['gc_country_id'])
				->value('u_region_id',$this->geo_data['gc_region_id'])
				->value('u_city_id',$this->geo_data['gc_city_id'])
				->value('u_birth_day',rand(1,31))
				->value('u_birth_month',rand(1,12))
				->value('u_birth_year',rand(1900,2010))
				->value('u_phone','+' . rand(111111111111,999999999999))
				->value('u_family',rand(1,5))
				->value('u_cophone','+' . rand(111111111111,999999999999))
				->value('u_icq',rand(111111111,999999999))
				->value('u_date_log',$this->online_time)
				->value('u_log_type',rand(User::LOGGED_DESKTOP,User::LOGGED_DEFAULT))
				->value('u_date_created',time())
				->value('u_status',rand(Kernel::STATUS_INACTIVE,Kernel::STATUS_BLOCKED))
				->value('u_user_type',2)
				->get()
				->id();

			Cache::getInstance()->key('users.all')->clear();

			return $this;
		}

















	}














