<?php

	namespace Core\Controllers\Avatar;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		protected $avatar_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->cache->key('avatar');
		}

		public function deleteAvatar(array $deleted_data,$avatar_id){

			$result = $this->update('photos')
				->field('p_status',Kernel::STATUS_DELETED)
				->field('p_date_deleted',$deleted_data['p_date_deleted'])
				->where("`p_id`=%avatar_id% AND `p_user_id`=%user_id%")
				->data('%avatar_id%',$avatar_id)
				->data('%user_id%',$deleted_data['p_user_id'])
				->get()
				->rows();

			return $result;
		}

		public function addAvatar(array $input_params){

			$insert = $this->insert('photos');

			foreach($input_params as $key=>$param){
				$insert = $insert->value($key,$param);
			}

			$insert = $insert->update('p_date_updated',$input_params['p_date_created']);
			$insert = $insert->update('p_micro',$input_params['p_micro']);
			$insert = $insert->update('p_small',$input_params['p_small']);
			$insert = $insert->update('p_medium',$input_params['p_medium']);
			$insert = $insert->update('p_normal',$input_params['p_normal']);
			$insert = $insert->update('p_big',$input_params['p_big']);
			$insert = $insert->get();
			$this->avatar_id = $insert->id();

			return $this->avatar_id;
		}


















	}














