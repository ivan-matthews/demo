<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertAdminAccount202006280939321593376772{

		private $user_id;
		private $password = 'Qwerty12345^';
		private $login = 'admin@m.c';

		public function addAuthData(){
			$this->user_id = Database::insert('auth')
				->value('login',$this->login)
				->value('password',fx_encode($this->password))
				->value('enc_password',fx_encryption($this->password))
				->value('groups',array(1,2,3,4,5))
				->value('bookmark',fx_encode($this->login.$this->password))
				->value('date_activate',time())
				->value('status',Kernel::STATUS_ACTIVE)
				->get()
				->id();
			return $this;
		}

		public function addUserData(){
			Database::insert('users')
				->value('auth_id',$this->user_id)
				->value('first_name','Admin')
				->value('last_name','Pitrovich')
				->value('full_name','Admin Pitrovich')
				->value('gender','m')
				->value('avatar_id',1)
				->value('status_id',1)
				->value('country_id',1)
				->value('city_id',1)
				->value('birth_day',20)
				->value('birth_month',12)
				->value('birth_year',1989)
				->value('phone','+2123433245324')
				->value('cophone','+24234325223324')
				->value('email',$this->login)
				->value('icq','321443575')
				->value('skype',$this->login)
				->value('viber',$this->login)
				->value('whatsapp',$this->login)
				->value('telegram',$this->login)
				->value('website','http://m.c')
				->value('activities','NaN')
				->value('interests','NaN')
				->value('music','NaN')
				->value('films','NaN')
				->value('shows','NaN')
				->value('books','NaN')
				->value('games','NaN')
				->value('citates','NaN')
				->value('about','NaN')
				->value('date_log',time())
				->value('date_reg',time())
				->value('log_type',time())
				->value('status',Kernel::STATUS_ACTIVE)
				->get()
				->id();
			return $this;
		}










	}