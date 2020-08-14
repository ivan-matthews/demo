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
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'bi.p_small as blog_image',
				'bi.p_date_updated as blog_image_date'
			)
				->from('blog')
				->join('users',"b_user_id=u_id")
				->join('photos as ui',"u_avatar_id=ui.p_id")
				->join('photos as bi',"b_image_preview_id=bi.p_id")
				->where($query)
				->limit($limit)
				->offset($offset)
				->order($order)
				->sort($sort)
				->get()
				->allAsArray();
			return $result;
		}

		public function getBlogPostById($post_id){
			$result = $this->select(
				'blog.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'bi.p_normal as blog_image',
				'bi.p_date_updated as blog_image_date'
			)
				->from('blog')
				->join('users',"b_user_id=u_id")
				->join('photos as ui',"u_avatar_id=ui.p_id")
				->join('photos bi',"b_image_preview_id=bi.p_id")
				->where("`b_status`=" . Kernel::STATUS_ACTIVE . " and `b_id`=%post_id%")
				->data('%post_id%',$post_id)
				->get()
				->itemAsArray();

			return $result;
		}

		public function getBlogPostBySlug($post_url){
			$result = $this->select(
				'blog.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'bi.p_normal as blog_image',
				'bi.p_date_updated as blog_image_date'
			)
				->from('blog')
				->join('users',"b_user_id=u_id")
				->join('photos as ui',"u_avatar_id=ui.p_id")
				->join('photos bi',"b_image_preview_id=bi.p_id")
				->where("`b_status`=" . Kernel::STATUS_ACTIVE . " and `b_slug`=%post_slug%")
				->data('%post_slug%',$post_url)
				->get()
				->itemAsArray();

			return $result;
		}

		public function deleteBlogPostItemById($blog_post_item_id,$user_id){
			$result = $this->update('blog')
				->field('b_status',Kernel::STATUS_DELETED)
				->field('b_date_deleted',time())
				->where("`b_id`=%post_id% AND `b_user_id`=%user_id%")
				->data('%post_id%',$blog_post_item_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();

			return $result;
		}

		public function updateTotalViewsForPostItem($post_item,$post_field_name='b_id'){
			$result = $this->update('blog')
				->query('b_total_views','b_total_views+1')
				->where("`{$post_field_name}`=%blog_id%")
				->data('%blog_id%',$post_item)
				->get()
				->rows();

			return $result;
		}

		public function addBlogPostItem(){

		}















	}














