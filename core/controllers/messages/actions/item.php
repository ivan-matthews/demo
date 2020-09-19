<?php

	namespace Core\Controllers\Messages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Messages\Config;
	use Core\Controllers\Messages\Controller;
	use Core\Controllers\Messages\Forms\Send_Message;
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

		public $user_data;
		public $contact_data;
		public $contacts;
		public $messages;

		public $query_string_to_update_read_status;
		public $total_count_readed_to_update=0;

		public $send_form;
		public $form_fields_list;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();

			$this->send_form = Send_Message::getInstance();
			$this->user_id = $this->user->getUID();
		}

		public function methodGet($contact_id){
			$this->contact_id = $contact_id;

			$this->contact_data = $this->model->getContactById($this->user_id,$this->contact_id);

			$this->setResponse();

			if($this->contact_data){

				$this->total = $this->model->countMessagesByContactId($this->user_id,$this->contact_id);

				$this->messages = $this->model->getMessagesByContactId(
					$this->user_id,
					$this->contact_id,
					$this->limit,
					$this->offset
				);

				$this->prepareMessagesIdsToUpdateQuery();

				if($this->query_string_to_update_read_status){
					$this->model->updateMessagesStatusRead(
						$this->total_count_readed_to_update,
						$this->user_id,
						$this->query_string_to_update_read_status
					);
				}

				// для *PHPStorm: перенесено, т.к. сначала выбирает
				// контакты, затем только обновляет прочитанные
				$this->contacts = $this->model->getContacts(
					$this->user_id,
					$this->limit_contacts,
					0,
					'total DESC',
					null
				);

				$this->paginate($this->total, array('messages','item',$this->contact_id));

				$this->send_form->generateFieldsList(
					$this->contact_id,
					(fx_equal($this->user_id,$this->contact_data['mc_receiver_id']) ?
						$this->contact_data['mc_sender_id'] : $this->contact_data['mc_receiver_id'])
				);
				$this->form_fields_list = $this->send_form->getFieldsList();

				$this->user_data = array(
					'u_id'		=> $this->session->get('u_id',Session::PREFIX_AUTH),
					'u_gender'	=> $this->session->get('u_gender',Session::PREFIX_AUTH),
					'p_micro'	=> $this->session->get('p_micro',Session::PREFIX_AUTH),
					'p_small'	=> $this->session->get('p_small',Session::PREFIX_AUTH),
				);

				$this->response->controller('messages','contact')
					->setArray(array(
						'contacts'	=> $this->contacts,
						'messages'	=> $this->messages,
						'total'		=> $this->total,
						'contact'	=> $this->contact_data,
						'user'		=> $this->user_data,
						'form_data'	=> array(
							'fields'	=> $this->form_fields_list,
							'form'		=> $this->send_form->getFormAttributes(),
							'errors'	=> $this->send_form->getErrors(),
						),
					));
				return $this;
			}

			return false;
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
				$this->total_count_readed_to_update++;
			}

			return $this->query_string_to_update_read_status = rtrim($messages_string,' OR ');
		}


















	}














