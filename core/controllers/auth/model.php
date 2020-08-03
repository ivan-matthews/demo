<?php

	namespace Core\Controllers\Auth;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		public $auth_id;
		public $user_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
		}

		public function addNewUser($auth_data){
			$this->auth_id = $this->insert('auth')
				->value('a_login',$auth_data['login'])
				->value('a_password',$auth_data['password'])
				->value('a_enc_password',$auth_data['enc_password'])
				->value('a_groups',$auth_data['groups'])
				->value('a_bookmark',$auth_data['bookmark'])
				->value('a_verify_token',$auth_data['verify_token'])
				->value('a_status',$auth_data['status'])
				->value('a_date_created',$auth_data['date_created'])
				->get()
				->id();

			$this->user_id = $this->insert('users')
				->value('u_auth_id',$this->auth_id)
				->value('u_status',$auth_data['status'])
				->value('u_date_created',$auth_data['date_created'])
				->value('u_log_type',$auth_data['log_type'])
				->value('u_date_log',$auth_data['date_log'])
				->get()
				->id();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $this->user_id;
		}

		public function updateUserAuthDataByRestorePasswordToken(array $update_data){
			$this->update('auth')
				->field('a_groups',$update_data['a_groups'])
				->field('a_verify_token',$update_data['a_verify_token'])
				->field('a_date_activate',$update_data['a_date_activate'])
				->field('a_status',$update_data['a_status'])
				->field('a_password',$update_data['a_password'])
				->field('a_enc_password',$update_data['a_enc_password'])
				->field('a_bookmark',$update_data['a_bookmark'])
				->field('a_restore_password_token',$update_data['a_restore_password_token'])
				->where("`a_id`=%auth_id%")
				->data('%auth_id%',$update_data['a_id'])
				->get()
				->rows();

			$this->update('users')
				->field('u_status',$update_data['u_status'])
				->where("`u_id`=%user_id% AND `u_auth_id`=%auth_id%")
				->data('%user_id%',$update_data['u_id'])
				->data('%auth_id%',$update_data['u_auth_id'])
				->get()
				->rows();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $this;
		}

		public function updateUserAuthDataByVerifyToken(array $update_data){
			$this->update('auth')
				->field('a_groups',$update_data['a_groups'])
				->field('a_verify_token',$update_data['a_verify_token'])
				->field('a_date_activate',$update_data['a_date_activate'])
				->field('a_status',$update_data['a_status'])
				->where("`a_id`=%auth_id%")
				->data('%auth_id%',$update_data['u_auth_id'])
				->get()
				->rows();

			$this->update('users')
				->field('u_status',$update_data['u_status'])
				->where("`u_id`=%user_id% AND `u_auth_id`=%auth_id%")
				->data('%user_id%',$update_data['u_id'])
				->data('%auth_id%',$update_data['u_auth_id'])
				->get()
				->rows();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $this;
		}

		public function updateUserEmail($user_email,$old_email){
			$rows = $this->update('auth')
				->field('a_login',$user_email)
				->where("`a_login`=%login%")
				->data('%login%',$old_email)
				->get()
				->rows();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $rows;
		}

		public function updateUserRestorePasswordToken(array $restore_data, $user_email){
			$rows = $this->update('auth')
				->field('a_restore_password_token',$restore_data['restore_password_token'])
				->field('a_date_password_restore',$restore_data['date_password_restore'])
				->where("`a_login`=%login%")
				->data('%login%',$user_email)
				->get()
				->rows();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $rows;
		}

		public function getUserByVerifyToken($verify_token){
			$this->cache->key('users.accounts.verify_tokens');

			if(($user_account = $this->cache->get()->array())){
				return $user_account;
			}

			$user_account = $this->select()
				->from('auth')
				->join('users',"a_id=u_auth_id")
				->join('photos FORCE INDEX (PRIMARY)',"u_avatar_id=p_id")
				->where("`a_verify_token`=%verify_token%")
				->data('%verify_token%',$verify_token)
				->limit(1)
				->get()
				->itemAsArray();

			$this->cache->set($user_account);
			return $user_account;
		}

		public function getUserByRestorePasswordToken($restore_password_token){
			$this->cache->key('users.accounts.pw_tokens');

			if(($user_account = $this->cache->get()->array())){
				return $user_account;
			}

			$user_account = $this->select()
				->from('auth')
				->join('users',"a_id=u_auth_id")
				->join('photos FORCE INDEX (PRIMARY)',"u_avatar_id=p_id")
				->where("`a_restore_password_token`=%restore_password_token%")
				->data('%restore_password_token%',$restore_password_token)
				->limit(1)
				->get()
				->itemAsArray();

			$this->cache->set($user_account);
			return $user_account;
		}

		public function getUserByBookmark($bookmark){
			$this->cache->key('users.accounts.bookmarks');

			if(($user_account = $this->cache->get()->array())){
				return $user_account;
			}

			$user_account = $this->select()
				->from('auth')
				->join('users',"a_id=u_auth_id")
				->join('photos FORCE INDEX (PRIMARY)',"u_avatar_id=p_id")
				->where("`a_bookmark`=%bookmark%")
				->data('%bookmark%',$bookmark)
				->limit(1)
				->get()
				->itemAsArray();

			$this->cache->set($user_account);
			return $user_account;
		}

		public function getAuthDataByLogin($login){
			$this->cache->key('users.accounts.login');

			if(($user_account = $this->cache->get()->array())){
				return $user_account;
			}

			$user_account = $this->select()
				->from('auth')
				->join('users',"a_id=u_auth_id")
				->join('photos FORCE INDEX (PRIMARY)',"u_avatar_id=p_id")
				->where("`a_login`=%login%")
				->data('%login%',$login)
				->limit(1)
				->get()
				->itemAsArray();

			$this->cache->set($user_account);
			return $user_account;
		}

		public function getAuthDataByUserId($user_id){
			$this->cache->key('users.accounts.ids');

			if(($user_account = $this->cache->get()->array())){
				return $user_account;
			}

			$user_account = $this->select()
				->from('auth')
				->join('users',"a_id=u_auth_id")
				->join('photos FORCE INDEX (PRIMARY)',"u_avatar_id=p_id")
				->where("u_id=%id%")
				->data('%id%',$user_id)
				->limit(1)
				->get()
				->itemAsArray();

			$this->cache->set($user_account);
			return $user_account;
		}

		public function emailExists($email){
			$this->cache->key('users.emails');

			if(($user_emails = $this->cache->get()->array())){
				return $user_emails;
			}

			$user_emails = $this->select()
				->from('auth')
				->where("`a_login`=%login%")
				->data('%login%',$email)
				->get()
				->itemAsArray();

			$this->cache->set($user_emails);
			return $user_emails;
		}

		public function generateVerifyTokenKey(){
			$generated_key = fx_gen(128);
			$verify_token_key = $this->select('a_verify_token')
				->from('auth')
				->where("`a_verify_token`='{$generated_key}'")
				->get()
				->itemAsArray();
			if($verify_token_key){
				return $this->generateVerifyTokenKey();
			}
			return $generated_key;
		}

		public function generateRestorePasswordToken(){
			$generated_key = fx_gen(128);
			$restore_token_key = $this->select('a_restore_password_token')
				->from('auth')
				->where("`a_restore_password_token`='{$generated_key}'")
				->get()
				->itemAsArray();
			if($restore_token_key){
				return $this->generateRestorePasswordToken();
			}
			return $generated_key;
		}

		public function updateDateLog($user_id,$date_log,$log_type){
			$this->update('users')
				->field('u_date_log',$date_log)
				->field('u_log_type',$log_type)
				->where("`u_id`=%user_id%")
				->data('%user_id%',$user_id)
				->get()
				->rows();
			return $this;
		}













	}














