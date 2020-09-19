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

		protected $result;

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

		public function countAllPosts($query,$preparing_data){
			$result = $this->select('COUNT(b_id) as total')
				->from('blog')
				->where($query)
				->prepare($preparing_data)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function getAllPosts($query,$limit,$offset,$order,$sort,$preparing_data){
			$result = $this->select(
				'blog.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'bi.p_small as blog_image',
				'bi.p_date_updated as blog_image_date',
				'bi.p_id as blog_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('blog')
				->join('categories FORCE INDEX(PRIMARY)',"b_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"b_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as bi FORCE INDEX(PRIMARY)',"b_image_preview_id=bi.p_id")
				->where($query)
				->prepare($preparing_data)
				->limit($limit)
				->offset($offset)
				->order($order)
				->sort($sort)
				->get()
				->allAsArray();
			return $result;
		}

		public function getBlogPostById($post_id,$image_size_field_key='p_normal'){
			$result = $this->select(
				'blog.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'bi.' . $image_size_field_key . ' as blog_image',
				'bi.p_date_updated as blog_image_date',
				'bi.p_id as blog_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('blog')
				->join('categories FORCE INDEX(PRIMARY)',"b_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"b_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as bi FORCE INDEX(PRIMARY)',"b_image_preview_id=bi.p_id")
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
				'bi.p_date_updated as blog_image_date',
				'bi.p_id as blog_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('blog')
				->join('categories FORCE INDEX(PRIMARY)',"b_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"b_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as bi FORCE INDEX(PRIMARY)',"b_image_preview_id=bi.p_id")
				->where("`b_status`=" . Kernel::STATUS_ACTIVE . " and `b_slug`=%post_slug%")
				->data('%post_slug%',$post_url)
				->get()
				->itemAsArray();

			return $result;
		}

		public function deleteBlogPostItemById($blog_post_item_id){
			$result = $this->update('blog')
				->field('b_status',Kernel::STATUS_DELETED)
				->field('b_date_deleted',time())
				->where("`b_id`=%post_id%")
				->data('%post_id%',$blog_post_item_id)
//				->data('%user_id%',$user_id)
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

		public function addBlogPostItem($insert_data){
			$post_insert_obj = $this->insert('blog');

			foreach($insert_data as $key=>$datum){
				$post_insert_obj = $post_insert_obj->value($key,$datum);
			}
			$post_id = $post_insert_obj->get()->id();

			return $post_id;
		}

		public function updatePostSlugById($item_id,$item_slug){
			$result = $this->update('blog')
				->field('b_slug',$item_slug)
				->where("`b_id`=%post_id%")
				->data('%post_id%',$item_id)
				->get()
				->rows();

			return $result;
		}

		public function editBlogPostItem($insert_data,$post_id){
			$post_insert_obj = $this->update('blog');

			foreach($insert_data as $key=>$datum){
				$post_insert_obj = $post_insert_obj->field($key,$datum);
			}
			$post_insert_obj = $post_insert_obj->where("`b_id`=%post_id%");
			$post_insert_obj = $post_insert_obj->data('%post_id%',$post_id);
			$post_rows = $post_insert_obj->get()->rows();

			return $post_rows;
		}

		public function countFind($search_query){
			$where_query = "b_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (b_title LIKE %search_query%";
				$where_query .= " OR b_content LIKE %search_query%";
				$where_query .= ")";
			}

			$this->result = $this->select('COUNT(b_id) as total')
				->from('blog')
				->join('users FORCE INDEX(PRIMARY)',"b_user_id = u_id")
				->where($where_query)
				->data('%search_query%',"%{$search_query}%")
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function find($search_query,$limit,$offset){
			$where_query = "b_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (b_title LIKE %search_query%";
				$where_query .= " OR b_content LIKE %search_query%";
				$where_query .= ")";
			}

			$order = "length(replace(b_title,%search_query%,%search_query%))+";
			$order .= "length(replace(b_content,%search_query%,%search_query%))";

			$this->result = $this->select(
				'p_small as image',
				'b_title as title',
				'b_content as description',
				'b_id as id',
				'p_date_updated as img_date',
				'u_gender as gender',
				'b_date_created as date'
			)
				->from('blog')
				->join('users FORCE INDEX(PRIMARY)',"b_user_id = u_id")
				->join('photos FORCE INDEX(PRIMARY)',"u_avatar_id = p_id")
				->where($where_query)
				->limit($limit)
				->offset($offset)
				->data('%search_query%',"%{$search_query}%")
				->order($order)
				->sort('DESC')
				->get()
				->allAsArray();
			return $this->result;
		}













	}














