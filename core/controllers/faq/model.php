<?php

	namespace Core\Controllers\Faq;

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
			$this->cache->key('faq');
		}

		public function __destruct(){

		}

		public function countItems($query,$prepared_data){
			$result = $this->select('COUNT(f_id) as total')
				->from('faq')
				->where($query)
				->prepare($prepared_data)
				->get()
				->itemAsArray();
			return $result['total'];
		}

		public function getItems($query,$prepared_data,$limit,$offset){
			$result = $this->select()
				->from('faq')
				->join("categories FORCE INDEX(PRIMARY)","f_category_id = ct_id")
				->where($query)
				->prepare($prepared_data)
				->limit($limit)
				->offset($offset)
				->order('f_id')
				->sort("ASC")
				->get()
				->allAsArray();
			return $result;
		}

		public function getItemByID($item_id){
			$result = $this->select()
				->from('faq')
				->join("categories FORCE INDEX(PRIMARY)","f_category_id = ct_id")
				->where("f_id = %faq_id% AND f_status = %active%")
				->data('%faq_id%',$item_id)
				->data('%active%',Kernel::STATUS_ACTIVE)
				->get()
				->itemAsArray();
			return $result;
		}

		public function addNewAnswer(array $insert_data){
			$result = $this->insert('faq')
				->value('f_question',$insert_data['question'])
				->value('f_answer',$insert_data['answer'])
				->value('f_category_id',$insert_data['category'])
				->value('f_date_created',time())
				->get()
				->id();
			return $result;
		}

		public function updateFaqAnswer(array $update_data,$item_id){
			$result = $this->update('faq')
				->field('f_question',$update_data['question'])
				->field('f_answer',$update_data['answer'])
				->field('f_category_id',$update_data['category'])
				->field('f_date_updated',time())
				->where("f_id=%answer_id%")
				->data('%answer_id%',$item_id)
				->get()
				->rows();
			return $result;
		}

		public function deleteAnswer($answer_id){
			$result = $this->update('faq')
				->field('f_status',Kernel::STATUS_DELETED)
				->field('f_date_deleted',time())
				->where("f_id = %answer_id%")
				->data('%answer_id%',$answer_id)
				->get()
				->rows();
			return $result;
		}















	}














