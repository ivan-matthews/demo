<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Classes\Config;
	use Core\Classes\User;

	class InsertAdminAccount202006280939321593376772{

		private $user_id;
		private $status = 'my first status data, more some values, more other data, more other items, more other info, or more... just more... ptichki poyut... volny shumiat... 😾 😈';
		private $password = 'Qwerty12345^';
		private $login = 'admin@m.c';

		private $file_name = 'demo.jpg';
		private $file = 'edf7cae3bedf012fe83d424f5357f4a1';
		private $file_hash = '1-edf7cae3bedf012fe83d424f5357f4a1';

		public function addAuthData(){
			$this->user_id = Database::insert('auth')
				->value('a_login',$this->login)
				->value('a_password',fx_encode($this->password))
				->value('a_enc_password',fx_encryption($this->password))
				->value('a_groups',array(2,3,4,5))
				->value('a_bookmark',fx_encode($this->login.$this->password))
				->value('a_date_activate',time())
				->value('a_status',Kernel::STATUS_ACTIVE)
				->value('a_date_created',time())
				->get()
				->id();
			return $this;
		}

		public function addUserData(){
			$online_time = Config::getInstance()->session['online_time']+time();
			Database::insert('users')
				->value('u_auth_id',$this->user_id)
				->value('u_first_name','Admin')
				->value('u_last_name','Pitrovich')
				->value('u_full_name','Admin Pitrovich')
				->value('u_gender',User::GENDER_MALE)
				->value('u_avatar_id',1)
				->value('u_status_id',1)
				->value('u_country_id',1)
				->value('u_city_id',1)
				->value('u_birth_day',20)
				->value('u_birth_month',12)
				->value('u_birth_year',1989)
				->value('u_phone','+2123433245324')
				->value('u_cophone','+24234325223324')
				->value('u_email',$this->login)
				->value('u_icq','321443575')
				->value('u_skype',$this->login)
				->value('u_viber',$this->login)
				->value('u_whatsapp',$this->login)
				->value('u_telegram',$this->login)
				->value('u_website','http://m.c')
				->value('u_activities','NaN')
				->value('u_interests','NaN')
				->value('u_music','NaN')
				->value('u_films','NaN')
				->value('u_shows','NaN')
				->value('u_books','NaN')
				->value('u_games','NaN')
				->value('u_citates','NaN')
				->value('u_about','NaN')
				->value('u_date_log',$online_time)
				->value('u_status',Kernel::STATUS_ACTIVE)
				->value('u_date_created',time())
				->get()
				->id();
			return $this;
		}

		public function addPhoto(){

			Database::insert("photos")
				->value("p_user_id",$this->user_id)
				->value("p_name",$this->file_name)
				->value("p_size",55796)
				->value("p_micro","users/{$this->user_id}/photos/ed/f7/micro-{$this->file}.jpeg")
				->value("p_small","users/{$this->user_id}/photos/ed/f7/small-{$this->file}.jpeg")
				->value("p_medium","users/{$this->user_id}/photos/ed/f7/medium-{$this->file}.jpeg")
				->value("p_normal","users/{$this->user_id}/photos/ed/f7/normal-{$this->file}.jpeg")
				->value("p_big","users/{$this->user_id}/photos/ed/f7/big-{$this->file}.jpeg")
				->value("p_original","users/{$this->user_id}/photos/ed/f7/original-{$this->file}.jpeg")
				->value("p_poster","users/{$this->user_id}/photos/ed/f7/poster-{$this->file}.jpeg")
				->value("p_hash",$this->file_hash)
				->value("p_mime","image/jpeg")
				->value('p_date_created',time())
				->value('p_date_updated',time())
				->get()
				->id();
			return $this;
		}

		public function addStatus(){
			Database::insert('status')
				->value('s_user_id',$this->user_id)
				->value('s_content',$this->status)
				->value('s_date_created',time())
				->get()
				->id();
			return $this;
		}









	}