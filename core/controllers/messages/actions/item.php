<?php

	namespace Core\Controllers\Messages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Messages\Config;
	use Core\Controllers\Messages\Controller;
	use Core\Controllers\Messages\Model;

	/**
	 * Get messages by contact_id
	 *
	 * Class Item
	 * @package Core\Controllers\Messages\Actions
	 */
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

		public $limit=30;
		public $limit_contacts=15;

		public $offset;
		public $total;
		public $order;
		public $sort;

		public $user_id;
		public $contact_id;

		public $contact_data;
		public $contacts;
		public $messages;

		public $query_string_to_update_read_status;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($contact_id){
			if(!fx_me($this->user_id)){ return false; }

			$this->contact_id = $contact_id;

			$this->contact_data = $this->model->getContactById($this->user_id,$this->contact_id);

			$this->setResponse();

			if($this->contact_data){

				$this->contacts = $this->model->getContacts(
					$this->user_id,
					$this->limit_contacts,
					0,
					'total'
				);

				$this->total = $this->model->countMessagesByContactId($this->user_id,$this->contact_id);

				$this->messages = $this->model->getMessagesByContactId(
					$this->user_id,
					$this->contact_id,
					$this->limit,
					$this->offset
				);

				$this->prepareMessagesIdsToUpdateQuery();

				if($this->query_string_to_update_read_status){
					$this->model->updateMessagesStatusRead($this->query_string_to_update_read_status);
				}

				$this->paginate($this->total, array('messages','item',$this->contact_id));

				$this->response->controller('messages','contact')
					->setArray(array(
						'contacts'	=> $this->contacts,
						'messages'	=> $this->messages,
						'total'		=> $this->total,
						'contact'	=> $this->contact_data,
						'user'		=> $this->user_id,
					));
				return $this;
			}

			return $this->renderEmptyPage();
		}


		public function setResponse(){
			$user_title = fx_get_full_name($this->contact_data['u_full_name'],$this->contact_data['u_gender']);

			$this->response->title('messages.messages_contacts_title');
			$this->response->breadcrumb('messages')
				->setValue('messages.messages_contacts_title')
				->setLink('messages','index')
				->setIcon(null);

			$this->response->title($user_title);
			$this->response->breadcrumb('messages_contact')
				->setValue($user_title)
				->setLink('messages','item',$this->contact_id)
				->setIcon(null);

			return $this;
		}

		public function prepareMessagesIdsToUpdateQuery(){
			$messages_string = '';
			foreach($this->messages as $message){
				if($message['m_readed']){ continue; }
				if(fx_equal($message['m_sender_id'],$this->user_id)){
					if(!fx_equal($message['m_sender_id'],$message['m_receiver_id'])){ continue; }
				}
				$messages_string .= "`m_id` = '{$message['m_id']}' OR ";
			}

			return $this->query_string_to_update_read_status = rtrim($messages_string,' OR ');
		}


















	}














