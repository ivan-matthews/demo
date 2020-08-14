<?php

	namespace Core\Controllers\Messages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Messages\Config;
	use Core\Controllers\Messages\Controller;
	use Core\Controllers\Messages\Forms\Add_Contact;
	use Core\Controllers\Messages\Model;

	/**
	 * Добавить новый контакт по USER_ID;
	 * USER_ID - обязательный параметр
	 *
	 * @GET:	получает форму на добавление сообщения
	 * @POST:	создает контакт по USER_ID
	 * 			добавляет первое сообщение
	 *
	 * Class Add
	 * @package Core\Controllers\Messages\Actions
	 */
	class Add extends Controller{

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
		public $add;

		public $receiver_id;
		public $sender_id;

		public $contact_id;
		public $last_message_id;

		public $updated_last_msg_id;

		public $form;
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

			$this->backLink();

			$this->form = Add_Contact::getInstance();
			$this->sender_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($receiver_id){
			$this->receiver_id = $receiver_id;

			$this->form->generateFieldsList($this->receiver_id);

			$this->form_fields_list = $this->form->getFieldsList();

			return $this->response->controller('messages','add_contact')
				->set('fields',$this->form_fields_list)
				->set('form',$this->form->getFormAttributes())
				->set('errors',$this->form->getErrors());
		}

		public function methodPost($receiver_id){
			$this->receiver_id = $receiver_id;

			$this->form->setData($this->request->getAll());
			$this->form->checkFieldsList($this->receiver_id);

			$this->form_fields_list = $this->form->getFieldsList();

			if($this->form->can()){

				$this->contact_id = $this->model->checkExistsContactOrAdd($this->sender_id,$this->receiver_id);

				if($this->contact_id){

					$this->last_message_id = $this->model->addNewMessage(
						$this->contact_id,
						$this->receiver_id,
						$this->sender_id,
						$this->form->getAttribute('message','value')
					);

					if($this->last_message_id){

						$this->updated_last_msg_id = $this->model->updateLastMessageId(
							$this->contact_id,$this->sender_id,$this->last_message_id
						);

						if($this->updated_last_msg_id){
							return $this->redirect(fx_get_url('messages','item',$this->contact_id));
						}

					}
				}
			}

			return $this->response->controller('messages','add_contact')
				->set('fields',$this->form_fields_list)
				->set('form',$this->form->getFormAttributes())
				->set('errors',$this->form->getErrors());
		}




















	}













