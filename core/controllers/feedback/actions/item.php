<?php

	namespace Core\Controllers\Feedback\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Feedback\Config;
	use Core\Controllers\Feedback\Controller;
	use Core\Controllers\Feedback\Model;

	class Item extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var Session */
		public $session;

		/** @var array */
		public $item;

		public $item_id;
		public $item_data;

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

		public function methodGet($item_id){
			$this->item_id = $item_id;

			$this->item_data = $this->model->getFeedbackItemByID($this->item_id);

			$this->setResponse();

			if($this->item_data){
				if(!$this->item_data['fb_date_updated'] && !fx_equal((int)$this->item_data['fb_status'],Kernel::STATUS_INACTIVE)){
					$this->model->readFeedbackItem($this->item_id);
				}

				$this->addResponse();

				$this->response->controller('feedback','item')
					->setArray(array(
						'item'	=> $this->item_data
					));
				return $this;
			}

			return $this->renderEmptyPage();
		}

		public function addResponse(){
			$cropped_title = fx_crop_string($this->item_data['fb_content'],50);
			$this->response->title($cropped_title);
			$this->response->breadcrumb('item')
				->setValue($cropped_title)
				->setIcon(null)
				->setLink('feedback','item',$this->item_data['fb_id']);
			return $this;
		}




















	}














