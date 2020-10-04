<?php

	namespace Core\Controllers\Pages;

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
			$this->cache->key('pages');
		}

		public function __destruct(){

		}

		public function countAllPosts($query,$preparing_data){
			$result = $this->select('COUNT(pg_id) as total')
				->from('pages')
				->where($query)
				->prepare($preparing_data)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function getAllPosts($query,$limit,$offset,$preparing_data){
			$result = $this->select(
				'pages.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'pg.p_micro as micro_pages_image',
				'pg.p_small as small_pages_image',
				'pg.p_medium as medium_pages_image',
				'pg.p_normal as normal_pages_image',
				'pg.p_big as big_pages_image',
				'pg.p_poster as poster_pages_image',
				'pg.p_date_updated as pages_image_date',
				'pg.p_id as pages_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('pages')
				->join('categories FORCE INDEX(PRIMARY)',"pg_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"pg_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as pg FORCE INDEX(PRIMARY)',"pg_image_preview_id=pg.p_id")
				->where($query)
				->prepare($preparing_data)
				->limit($limit)
				->offset($offset)
				->order('pg_id')
				->sort('DESC')
				->get()
				->allAsArray();
			return $result;
		}

		public function getBlogPostById($post_id){
			$result = $this->select(
				'pages.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'pg.p_micro as micro_pages_image',
				'pg.p_small as small_pages_image',
				'pg.p_medium as medium_pages_image',
				'pg.p_normal as normal_pages_image',
				'pg.p_big as big_pages_image',
				'pg.p_poster as poster_pages_image',
				'pg.p_date_updated as pages_image_date',
				'pg.p_id as pages_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('pages')
				->join('categories FORCE INDEX(PRIMARY)',"pg_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"pg_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as pg FORCE INDEX(PRIMARY)',"pg_image_preview_id=pg.p_id")
				->where("`pg_status`=" . Kernel::STATUS_ACTIVE . " and `pg_id`=%post_id%")
				->data('%post_id%',$post_id)
				->get()
				->itemAsArray();

			return $result;
		}

		public function getBlogPostBySlug($post_url){
			$result = $this->select(
				'pages.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'pg.p_micro as micro_pages_image',
				'pg.p_small as small_pages_image',
				'pg.p_medium as medium_pages_image',
				'pg.p_normal as normal_pages_image',
				'pg.p_big as big_pages_image',
				'pg.p_poster as poster_pages_image',
				'pg.p_date_updated as pages_image_date',
				'pg.p_id as pages_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('pages')
				->join('categories FORCE INDEX(PRIMARY)',"pg_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"pg_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as pg FORCE INDEX(PRIMARY)',"pg_image_preview_id=pg.p_id")
				->where("`pg_status`=" . Kernel::STATUS_ACTIVE . " and `pg_slug`=%post_slug%")
				->data('%post_slug%',$post_url)
				->get()
				->itemAsArray();

			return $result;
		}

		public function deleteBlogPostItemById($pages_post_item_id){
			$result = $this->update('pages')
				->field('pg_status',Kernel::STATUS_DELETED)
				->field('pg_date_deleted',time())
				->where("`pg_id`=%post_id%")
				->data('%post_id%',$pages_post_item_id)
//				->data('%user_id%',$user_id)
				->get()
				->rows();

			return $result;
		}

		public function updateTotalViewsForPostItem($post_item,$post_field_name='pg_id'){
			$result = $this->update('pages')
				->query('pg_total_views','pg_total_views+1')
				->where("`{$post_field_name}`=%pages_id%")
				->data('%pages_id%',$post_item)
				->get()
				->rows();

			return $result;
		}

		public function addBlogPostItem($insert_data){
			$post_insert_obj = $this->insert('pages');

			foreach($insert_data as $key=>$datum){
				$post_insert_obj = $post_insert_obj->value($key,$datum);
			}
			$post_id = $post_insert_obj->get()->id();

			return $post_id;
		}

		public function updatePostSlugById($item_id,$item_slug){
			$result = $this->update('pages')
				->field('pg_slug',$item_slug)
				->where("`pg_id`=%post_id%")
				->data('%post_id%',$item_id)
				->get()
				->rows();

			return $result;
		}

		public function editBlogPostItem($insert_data,$post_id){
			$post_insert_obj = $this->update('pages');

			foreach($insert_data as $key=>$datum){
				$post_insert_obj = $post_insert_obj->field($key,$datum);
			}
			$post_insert_obj = $post_insert_obj->where("`pg_id`=%post_id%");
			$post_insert_obj = $post_insert_obj->data('%post_id%',$post_id);
			$post_rows = $post_insert_obj->get()->rows();

			return $post_rows;
		}

		public function countFind($search_query){
			$where_query = "pg_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (pg_title LIKE %search_query%";
				$where_query .= " OR pg_content LIKE %search_query%";
				$where_query .= ")";
			}

			$this->result = $this->select('COUNT(pg_id) as total')
				->from('pages')
				->join('users FORCE INDEX(PRIMARY)',"pg_user_id = u_id")
				->where($where_query)
				->data('%search_query%',"%{$search_query}%")
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function find($search_query,$limit,$offset){
			$where_query = "pg_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (pg_title LIKE %search_query%";
				$where_query .= " OR pg_content LIKE %search_query%";
				$where_query .= ")";
			}

			$order = "length(replace(pg_title,%search_query%,%search_query%))+";
			$order .= "length(replace(pg_content,%search_query%,%search_query%))";

			$this->result = $this->select(
				'p_small as image',
				'pg_title as title',
				'pg_content as description',
				'pg_id as id',
				'p_date_updated as img_date',
				'u_gender as gender',
				'pg_date_created as date'
			)
				->from('pages')
				->join('users FORCE INDEX(PRIMARY)',"pg_user_id = u_id")
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














