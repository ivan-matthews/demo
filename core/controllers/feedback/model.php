<?php

	namespace Core\Controllers\Feedback;

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
			$this->cache->key('feedback');
		}

		public function __destruct(){

		}

		public function addFeedbackQuestion($data_to_insert){
			$result = $this->insert('feedback')
				->value('fb_name',$data_to_insert['fb_name'])
				->value('fb_phone',$data_to_insert['fb_phone'])
				->value('fb_email',$data_to_insert['fb_email'])
				->value('fb_content',$data_to_insert['fb_content'])
				->value('fb_date_created',time())
				->get()
				->id();
			return $result;
		}

		public function countFeedbackItems($query,array $data_to_prepare){
			$result = $this->select('COUNT(fb_id) as total')
				->from('feedback')
				->where($query)
				->prepare($data_to_prepare)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function getFeedbackItems($query,array $data_to_prepare,$limit,$offset){
			$result = $this->select()
				->from('feedback')
				->where($query)
				->prepare($data_to_prepare)
				->limit($limit)
				->offset($offset)
				->order('fb_status DESC, fb_id DESC')
				->sort(null)
				->get()
				->allAsArray();
			return $result;
		}

		public function getFeedbackItemByID($item_id){
			$result = $this->select()
				->from('feedback')
				->where("fb_id = %item_id%")
				->data('%item_id%',$item_id)
				->get()
				->itemAsArray();
			return $result;
		}

		public function readFeedbackItem($item_id){
			$result = $this->update('feedback')
				->field('fb_status',Kernel::STATUS_INACTIVE)
				->field('fb_date_updated',time())
				->where("fb_id = %feedback_item_id%")
				->data('%feedback_item_id%',$item_id)
				->get()
				->rows();
			return $result;
		}

		public function deleteFeedbackItem($item_id){
			$result = $this->update('feedback')
				->field('fb_status',Kernel::STATUS_DELETED)
				->field('fb_date_deleted',time())
				->where("fb_id = %feedback_item_id%")
				->data('%feedback_item_id%',$item_id)
				->get()
				->rows();
			return $result;
		}

		public function updateAnswer($item_id,$answer){
			$result = $this->update('feedback')
				->field('fb_answer',$answer)
				->field('fb_date_updated',time())
				->where("fb_id = %item_id%")
				->data('%item_id%',$item_id)
				->get()
				->rows();
			return $result;
		}

		public function getFeedbackContacts(){
			$result = $this->select(
				'gc_title_ru',
				'gc_title_en',
				'gr_title_ru',
				'gr_title_en',
				'g_title_ru',
				'g_title_en',
				'fc_street',
				'fc_house',
				'fc_apartments',
				'fc_title',
				'u_first_name',
				'p_micro',
				'u_gender',
				'u_full_name',
				'u_phone',
				'u_cophone',
				'u_email',
				'u_whatsapp',
				'u_viber',
				'u_telegram',
				'u_skype',
				'u_icq',
				'fc_description',
				'u_country_id',
				'u_region_id',
				'u_city_id'
			)
				->from('feedback_contacts')
				->join('users FORCE INDEX(PRIMARY)',"fc_operator_id = u_id")
				->join('photos FORCE INDEX(PRIMARY)',"u_avatar_id = p_id")
				->join('geo_cities FORCE INDEX(PRIMARY)',"u_city_id = gc_city_id")
				->join('geo_regions FORCE INDEX(PRIMARY)',"u_region_id = gr_region_id")
				->join('geo_countries FORCE INDEX(PRIMARY)',"u_country_id = g_country_id")
				->where('fc_status = ' . Kernel::STATUS_ACTIVE)
				->get()
				->allAsArray();

			if($result){
				$new_result_array = array();
				foreach($result as $value){
					$key = $value['u_country_id'] . $value['u_region_id'] .
						$value['u_city_id'] . $value['fc_street'] .
						$value['fc_house'] . $value['fc_apartments'];
					$new_result_array[md5($key)][] = $value;
				}
				return $new_result_array;
			}

			return $result;
		}












	}














