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
				->value('login',$auth_data['login'])
				->value('password',$auth_data['password'])
				->value('enc_password',$auth_data['enc_password'])
				->value('groups',$auth_data['groups'])
				->value('bookmark',$auth_data['bookmark'])
				->value('verify_token',$auth_data['verify_token'])
				->value('status',$auth_data['status'])
				->value('date_created',$auth_data['date_created'])
				->get()
				->id();

			$this->user_id = $this->insert('users')
				->value('auth_id',$this->auth_id)
				->value('status',$auth_data['status'])
				->value('date_created',$auth_data['date_created'])
				->get()
				->id();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $this->user_id;
		}

		public function updateUserAuthDataByRestorePasswordToken(array $update_data){
			$this->update('auth')
				->field('groups',$update_data['groups'])
				->field('verify_token',$update_data['verify_token'])
				->field('date_activate',$update_data['date_activate'])
				->field('status',$update_data['status'])
				->field('password',$update_data['password'])
				->field('enc_password',$update_data['enc_password'])
				->field('bookmark',$update_data['bookmark'])
				->field('restore_password_token',$update_data['restore_password_token'])
				->where("`id`=%auth_id%")
				->data('%auth_id%',$update_data['auth_id'])
				->get()
				->rows();

			$this->update('users')
				->field('status',$update_data['status'])
				->where("`id`=%user_id% AND `auth_id`=%auth_id%")
				->data('%user_id%',$update_data['id'])
				->data('%auth_id%',$update_data['auth_id'])
				->get()
				->rows();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $this;
		}

		public function updateUserAuthDataByVerifyToken(array $update_data){
			$this->update('auth')
				->field('groups',$update_data['groups'])
				->field('verify_token',$update_data['verify_token'])
				->field('date_activate',$update_data['date_activate'])
				->field('status',$update_data['status'])
				->where("`id`=%auth_id%")
				->data('%auth_id%',$update_data['auth_id'])
				->get()
				->rows();

			$this->update('users')
				->field('status',$update_data['status'])
				->where("`id`=%user_id% AND `auth_id`=%auth_id%")
				->data('%user_id%',$update_data['id'])
				->data('%auth_id%',$update_data['auth_id'])
				->get()
				->rows();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $this;
		}

		public function updateUserEmail($user_email,$old_email){
			$rows = $this->update('auth')
				->field('login',$user_email)
				->where("`login`=%login%")
				->data('%login%',$old_email)
				->get()
				->rows();

			$this->cache->key('users.emails')->clear();
			$this->cache->key('users.accounts')->clear();

			return $rows;
		}

		public function updateUserRestorePasswordToken(array $restore_data, $user_email){
			$rows = $this->update('auth')
				->field('restore_password_token',$restore_data['restore_password_token'])
				->field('date_password_restore',$restore_data['date_password_restore'])
				->where("`login`=%login%")
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
				->join('users',"auth.id=users.auth_id")
				->where("`verify_token`=%verify_token%")
				->data('%verify_token%',$verify_token)
				->limit(1)
				->get()
				->itemAsArray();

			$this->cache->set($user_account);
			return $user_account;
		}

		public function getUserByRestorePasswordToken($restore_password_token){
			$this->cache->key('users.accounts.restore_password_tokens');

			if(($user_account = $this->cache->get()->array())){
				return $user_account;
			}

			$user_account = $this->select()
				->from('auth')
				->join('users',"auth.id=users.auth_id")
				->where("`restore_password_token`=%restore_password_token%")
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
				->join('users',"auth.id=users.auth_id")
				->where("`bookmark`=%bookmark%")
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
				->join('users',"auth.id=users.auth_id")
				->where("`login`=%login%")
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
				->join('users',"auth.id=users.auth_id")
				->where("users.id=%id%")
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
				->where("`login`=%login%")
				->data('%login%',$email)
				->get()
				->itemAsArray();

			$this->cache->set($user_emails);
			return $user_emails;
		}

		public function generateVerifyTokenKey(){
			$generated_key = fx_gen(128);
			$verify_token_key = $this->select('verify_token')
				->from('auth')
				->where("`verify_token`='{$generated_key}'")
				->get()
				->itemAsArray();
			if($verify_token_key){
				return $this->generateVerifyTokenKey();
			}
			return $generated_key;
		}

		public function generateRestorePasswordToken(){
			$generated_key = fx_gen(128);
			$restore_token_key = $this->select('restore_password_token')
				->from('auth')
				->where("`restore_password_token`='{$generated_key}'")
				->get()
				->itemAsArray();
			if($restore_token_key){
				return $this->generateRestorePasswordToken();
			}
			return $generated_key;
		}
















	}














