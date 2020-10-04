<?php

	namespace Core\Controllers\News;

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
			$this->cache->key('news');
		}

		public function __destruct(){

		}

		public function countAllPosts($query,$preparing_data){
			$result = $this->select('COUNT(nw_id) as total')
				->from('news')
				->where($query)
				->prepare($preparing_data)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function getAllPosts($query,$limit,$offset,$order,$sort,$preparing_data){
			$result = $this->select(
				'news.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'nw.p_micro as micro_news_image',
				'nw.p_small as small_news_image',
				'nw.p_medium as medium_news_image',
				'nw.p_normal as normal_news_image',
				'nw.p_big as big_news_image',
				'nw.p_poster as poster_news_image',
				'nw.p_original as original_news_image',
				'nw.p_date_updated as news_image_date',
				'nw.p_id as news_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('news')
				->join('categories FORCE INDEX(PRIMARY)',"nw_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"nw_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as nw FORCE INDEX(PRIMARY)',"nw_image_preview_id=nw.p_id")
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

		public function getNewsPostById($post_id){
			$result = $this->select(
				'news.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'nw.p_micro as micro_news_image',
				'nw.p_small as small_news_image',
				'nw.p_medium as medium_news_image',
				'nw.p_normal as normal_news_image',
				'nw.p_big as big_news_image',
				'nw.p_poster as poster_news_image',
				'nw.p_original as original_news_image',
				'nw.p_date_updated as news_image_date',
				'nw.p_id as news_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('news')
				->join('categories FORCE INDEX(PRIMARY)',"nw_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"nw_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as nw FORCE INDEX(PRIMARY)',"nw_image_preview_id=nw.p_id")
				->where("`nw_status`=" . Kernel::STATUS_ACTIVE . " and `nw_id`=%post_id%")
				->data('%post_id%',$post_id)
				->get()
				->itemAsArray();

			return $result;
		}

		public function getNewsPostBySlug($post_url){
			$result = $this->select(
				'news.*',
				'users.u_id',
				'users.u_full_name',
				'users.u_avatar_id',
				'users.u_gender',
				'ui.p_micro',
				'ui.p_date_updated',
				'nw.p_micro as micro_news_image',
				'nw.p_small as small_news_image',
				'nw.p_medium as medium_news_image',
				'nw.p_normal as normal_news_image',
				'nw.p_big as big_news_image',
				'nw.p_poster as poster_news_image',
				'nw.p_original as original_news_image',
				'nw.p_date_updated as news_image_date',
				'nw.p_id as news_image_id',
				'categories.ct_id',
				'categories.ct_title',
				'categories.ct_icon',
				'categories.ct_controller'
			)
				->from('news')
				->join('categories FORCE INDEX(PRIMARY)',"nw_category_id=ct_id")
				->join('users FORCE INDEX(PRIMARY)',"nw_user_id=u_id")
				->join('photos as ui FORCE INDEX(PRIMARY)',"u_avatar_id=ui.p_id")
				->join('photos as nw FORCE INDEX(PRIMARY)',"nw_image_preview_id=nw.p_id")
				->where("`nw_status`=" . Kernel::STATUS_ACTIVE . " and `nw_slug`=%post_slug%")
				->data('%post_slug%',$post_url)
				->get()
				->itemAsArray();

			return $result;
		}

		public function deleteNewsPostItemById($news_post_item_id){
			$result = $this->update('news')
				->field('nw_status',Kernel::STATUS_DELETED)
				->field('nw_date_deleted',time())
				->where("`nw_id`=%post_id%")
				->data('%post_id%',$news_post_item_id)
//				->data('%user_id%',$user_id)
				->get()
				->rows();

			return $result;
		}

		public function updateTotalViewsForPostItem($post_item,$post_field_name='nw_id'){
			$result = $this->update('news')
				->query('nw_total_views','nw_total_views+1')
				->where("`{$post_field_name}`=%news_id%")
				->data('%news_id%',$post_item)
				->get()
				->rows();

			return $result;
		}

		public function addNewsPostItem($insert_data){
			$post_insert_obj = $this->insert('news');

			foreach($insert_data as $key=>$datum){
				$post_insert_obj = $post_insert_obj->value($key,$datum);
			}
			$post_id = $post_insert_obj->get()->id();

			return $post_id;
		}

		public function updatePostSlugById($item_id,$item_slug){
			$result = $this->update('news')
				->field('nw_slug',$item_slug)
				->where("`nw_id`=%post_id%")
				->data('%post_id%',$item_id)
				->get()
				->rows();

			return $result;
		}

		public function editNewsPostItem($insert_data,$post_id){
			$post_insert_obj = $this->update('news');

			foreach($insert_data as $key=>$datum){
				$post_insert_obj = $post_insert_obj->field($key,$datum);
			}
			$post_insert_obj = $post_insert_obj->where("`nw_id`=%post_id%");
			$post_insert_obj = $post_insert_obj->data('%post_id%',$post_id);
			$post_rows = $post_insert_obj->get()->rows();

			return $post_rows;
		}

		public function countFind($search_query){
			$where_query = "nw_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (nw_title LIKE %search_query%";
				$where_query .= " OR nw_content LIKE %search_query%";
				$where_query .= ")";
			}

			$this->result = $this->select('COUNT(nw_id) as total')
				->from('news')
				->join('users FORCE INDEX(PRIMARY)',"nw_user_id = u_id")
				->where($where_query)
				->data('%search_query%',"%{$search_query}%")
				->get()
				->itemAsArray();
			return $this->result['total'];
		}

		public function find($search_query,$limit,$offset){
			$where_query = "nw_status = " . Kernel::STATUS_ACTIVE;
			$where_query .= " AND u_status = " . Kernel::STATUS_ACTIVE;
			if($search_query){
				$where_query .= " AND (nw_title LIKE %search_query%";
				$where_query .= " OR nw_content LIKE %search_query%";
				$where_query .= ")";
			}

			$order = "length(replace(nw_title,%search_query%,%search_query%))+";
			$order .= "length(replace(nw_content,%search_query%,%search_query%))";

			$this->result = $this->select(
				'p_small as image',
				'nw_title as title',
				'nw_content as description',
				'nw_id as id',
				'p_date_updated as img_date',
				'u_gender as gender',
				'nw_date_created as date'
			)
				->from('news')
				->join('users FORCE INDEX(PRIMARY)',"nw_user_id = u_id")
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














