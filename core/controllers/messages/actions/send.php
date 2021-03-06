<?php

	namespace Core\Controllers\Messages\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Messages\Config;
	use Core\Controllers\Messages\Controller;
	use Core\Controllers\Messages\Model;
	use Core\Controllers\Messages\Forms\Send_Message;
	use Core\Controllers\Attachments\Controller as AttachmentsController;

	/**
	 * Отправка сообщений по CONTACT_ID;
	 * CONTACT_ID - обязательный параметр
	 *
	 * @GET:	получить форму
	 * @POST:	оправить форму с сообщением
	 * 			контакт ранее создан в экшине Core\Controllers\Messages\Actions\Add::methodPost(int user_id);
	 *
	 * Class Send
	 * @package Core\Controllers\Messages\Actions
	 */
	class Send extends Controller{

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
		public $send;

		public $sender_id;
		public $receiver_id;
		public $contact_id;
		public $form;
		public $form_fields_list;

		public $last_message_id;
		public $updated_last_msg_id;

		/** @var AttachmentsController */
		public $attachments_controller;
		public $attachments_ids;
		public $attachments_data;

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

			$this->form = Send_Message::getInstance();
			$this->sender_id = $this->user->getUID();
		}

		public function methodGet($contact_id,$receiver_id){
			$this->contact_id = $contact_id;
			$this->receiver_id = $receiver_id;

			$this->form->generateFieldsList($this->contact_id,$this->receiver_id);

			$this->form_fields_list = $this->form->getFieldsList();

			return $this->response->controller('messages','send_message')
				->set('fields',$this->form_fields_list)
				->set('form',$this->form->getFormAttributes())
				->set('errors',$this->form->getErrors());
		}

		public function methodPost($contact_id,$receiver_id){
			$this->contact_id = $contact_id;
			$this->receiver_id = $receiver_id;

			if(!$this->contact_id){ return false; }

			$this->form->setData($this->request->getAll());
			$this->form->checkFieldsList($this->contact_id,$this->receiver_id);

			$this->form_fields_list = $this->form->getFieldsList();

			$this->attachments_ids = $this->attachments_controller->prepareAttachments($this->request->getArray('attachments'),'attachments');
			$this->attachments_data = $this->attachments_controller->getAttachmentsFromIDsList($this->attachments_ids,$this->sender_id);
			$this->form->setParams('variants',array(
				'ids'	=> $this->attachments_ids,
				'data'	=> $this->attachments_data
			),'attachments');

			if($this->form->can()){

				$this->last_message_id = $this->model->addNewMessage(
					$this->contact_id,
					$this->receiver_id,
					$this->sender_id,
					$this->form->getAttribute('message','value'),
					$this->attachments_ids
				);

				if($this->last_message_id){

					$this->updated_last_msg_id = $this->model->updateLastMessageId(
						$this->contact_id,
						$this->sender_id,
						$this->last_message_id
					);

					if($this->updated_last_msg_id){
						return $this->redirect(fx_get_url('messages','item',$this->contact_id));
					}

				}
			}

			return $this->redirect(fx_get_url('messages','item',$this->contact_id));
		}




















	}














