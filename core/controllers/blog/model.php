<?php

	namespace Core\Controllers\Blog;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;
	use Core\Classes\Kernel;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->cache->key('blog');
		}

		public function __destruct(){

		}

		public function countAllPosts($query){
			$result = $this->select('COUNT(b_id) as total')
				->from('blog')
				->where($query)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function getAllPosts($query,$limit,$offset,$order,$sort){
			$result = $this->select(
				'blog.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'ui.p_micro',
				'ui.p_date_updated',
				'bi.p_small as blog_image',
				'bi.p_date_updated as blog_image_date'
			)
				->from('blog')
				->join('users',"b_user_id=u_id")
				->join('photos as ui',"u_avatar_id=ui.p_id")
				->join('photos bi',"b_image_preview_id=bi.p_id")
				->where($query)
				->limit($limit)
				->offset($offset)
				->order($order)
				->sort($sort)
				->get()
				->allAsArray();
			return $result;
		}



















	}














