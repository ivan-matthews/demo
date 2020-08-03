<?php

	namespace Core\Controllers\Messages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Messages\Config;
	use Core\Controllers\Messages\Controller;
	use Core\Controllers\Messages\Model;

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

		public $contacts;

		public $contact;
		public $user_id;

		public $contact_info;
		public $messages;

		public $limit = 30;
		public $offset;
		public $total;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->item[$key])){
				return $this->item[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->item[$name] = $value;
			return $this->item[$name];
		}

		public function __construct(){
			parent::__construct();
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($messages_contact){
			$this->contact = $messages_contact;

			$this->contact_info = $this->model->getContactById($this->contact);

			$this->setResponse();

			if($this->contact_info){
				$this->contacts = $this->model->getContacts($this->user_id,10,0);

				$this->total = $this->model->countMessagesByContactId(
					$this->contact_info['mc_user_id'],
					$this->contact_info['mc_sender_id']
				);

				$this->messages = $this->model->getMessagesByContactId(
					$this->contact_info['mc_user_id'],
					$this->contact_info['mc_sender_id'],
					$this->limit,
					$this->offset
				);

				if($this->messages){
					$update_messages_query_string = ltrim($this->getMessagesUpdateQueryString(),' OR ');
					if($update_messages_query_string){
						$this->model->updateMessagesAsReadByIDs($update_messages_query_string);
					}
				}

				$this->paginate($this->total, array('messages','item',$this->user_id,$this->contact));

				$this->response->controller('messages','contact')
					->setArray(array(
						'contacts'	=> $this->contacts,
						'messages'	=> $this->messages,
						'total'		=> $this->total,
						'contact'	=> $this->contact_info,
						'user'		=> $this->user_id,
					));

				return $this;
			}

			return $this->renderEmptyPage();
		}


		public function setResponse(){
			$user_title = fx_get_full_name($this->contact_info['u_full_name'],$this->contact_info['u_gender']);

			$this->response->title('messages.messages_contacts_title');
			$this->response->breadcrumb('messages')
				->setValue('messages.messages_contacts_title')
				->setLink('messages','index')
				->setIcon(null);

			$this->response->title($user_title);
			$this->response->breadcrumb('messages_contact')
				->setValue($user_title)
				->setLink('messages','item',$this->contact)
				->setIcon(null);

			return $this;
		}

		public function getMessagesUpdateQueryString(){
			$messages_string = '';
			foreach($this->messages as $message){
				if($message['m_date_read']){ continue; }
				if(fx_equal($message['mc_sender_id'],$this->user_id)){
					if(!fx_equal($message['mc_sender_id'],$message['mc_user_id'])){ continue; }
				}
				$messages_string .= " OR `m_id` = '{$message['m_id']}'";
			}
			return $messages_string;
		}















	}














