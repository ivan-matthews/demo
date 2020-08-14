<?php

	namespace Core\Controllers\Comments\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Mail\Notice;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Config;
	use Core\Controllers\Comments\Controller;
	use Core\Controllers\Comments\Forms\Reply_Comment;
	use Core\Controllers\Comments\Model;

	class Reply extends Controller{

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
		public $reply;
		public $reply_form;

		public $controller;				// контроллер для которого устанавливаем коммент
		public $action;					// экшон для которого устанавливаем коммент
		public $item_id;				// ID-записи  для которого устанавливаем коммент

		public $sender_id;				// я (пользователь из сессии)
		public $receiver_id;			// автор КОНТЕНТА
		public $author_id;				// автор КОММЕНТАРИЯ

		public $parent_id;				// родительский комментарий

		public $comment_id;				// ласт-ID из инзерта
		public $comment_content;		// POST-данные поля комментария
		public $back_url;				// ссылка назад

		public $ids_to_notice_send;

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

			$this->back_url = $this->user->getBackUrl();
			$this->reply_form = Reply_Comment::getInstance();
			$this->sender_id = $this->session->get('u_id',Session::PREFIX_AUTH);
		}

		public function methodGet($controller,$action,$item_id,$parent_id,$author_id,$receiver_id){
			$this->controller = $controller;
			$this->action = $action;
			$this->item_id = $item_id;
			$this->receiver_id = $receiver_id;
			$this->parent_id = $parent_id;
			$this->author_id = $author_id;

			if(!$this->checkAllowedController()){ return false; }

			$this->reply_form->generateFieldsList($this->controller, $this->action, $this->item_id, $this->parent_id, $this->author_id, $this->receiver_id);

			$this->response->controller('comments','add')
				->setArray(array(
					'form'		=> $this->reply_form->getFormAttributes(),
					'fields'	=> $this->reply_form->getFieldsList(),
					'errors'	=> $this->reply_form->getErrors(),
				));

			return $this;
		}

		public function methodPost($controller,$action,$item_id,$parent_id,$author_id,$receiver_id){
			$this->controller = $controller;
			$this->action = $action;
			$this->item_id = $item_id;
			$this->receiver_id = $receiver_id;
			$this->parent_id = $parent_id;
			$this->author_id = $author_id;

			if(!$this->checkAllowedController()){ return false; }

			$this->reply_form->setData($this->request->getAll());
			$this->reply_form->checkFieldsList($this->controller, $this->action, $this->item_id, $this->parent_id, $this->author_id, $this->receiver_id);

			$this->setResponse();

			if($this->reply_form->can()){
				$this->comment_content = $this->reply_form->getAttribute('comment','value');

				$this->comment_id = $this->model->addParentComment(
					$this->controller,
					$this->action,
					$this->item_id,
					$this->sender_id,
					$this->parent_id,
					$this->author_id,
					$this->comment_content
				);
				if($this->comment_id){
					$this->model->updateTotalComments(
						$this->params->allowed_controllers[$this->controller]['table_name'],
						$this->params->allowed_controllers[$this->controller]['count_field'],
						$this->params->allowed_controllers[$this->controller]['id_field'],
						$this->item_id,
						"{$this->params->allowed_controllers[$this->controller]['count_field']}+1"
					);

					return $this->sendNotice()->redirect("{$this->back_url}#{$this->comments_list_id}");
				}
			}

			$this->response->controller('comments','add')
				->setArray(array(
					'form'		=> $this->reply_form->getFormAttributes(),
					'fields'	=> $this->reply_form->getFieldsList(),
					'errors'	=> $this->reply_form->getErrors(),
				));

			return $this;
		}

		public function setResponse(){
			$this->response->title('comments.comments_controller_title');
			$this->response->breadcrumb('comment')
				->setValue('comments.comments_controller_title')
				->setLink('comments','add',$this->controller,$this->action,$this->item_id)
				->setIcon(null);
			return $this;
		}

		public function sendNotice(){
			$this->ids_to_notice_send = $this->model->getLastCommentatorsIDsForReplyAction(
				$this->controller,
				$this->action,
				$this->item_id,
				$this->sender_id,
				$this->receiver_id,
				$this->author_id,
				$this->limit_notices_author
			);

			$cropped_content_string = fx_crop_string($this->comment_content,50);
			$send_obj = Notice::ready();

			if($this->ids_to_notice_send){					// отправить последним комментаторам уведомлени
				$unique_ids = array();
				foreach($this->ids_to_notice_send as $value){

					if(isset($unique_ids[$value['c_author_id']])){ continue; }
					$unique_ids[$value['c_author_id']] = true;

					$send_obj = $send_obj->theme('comments.send_notice_title');
					$send_obj = $send_obj->sender($this->sender_id);
					$send_obj = $send_obj->manager(Notice::MANAGER_SYSTEM);
					$send_obj = $send_obj->receiver($value['c_author_id']);
					$send_obj = $send_obj->action($this->controller,$this->action,$this->item_id);
					$send_obj = $send_obj->key("{$this->controller}.{$this->action}.{$this->item_id}.{$value['c_author_id']}");
					$send_obj = $send_obj->content($cropped_content_string);
					$send_obj = $send_obj->create();
				}
			}

			if(!fx_me($this->receiver_id)){
				$send_obj->theme('comments.send_notice_title')			// отправить автору контента
					->sender($this->sender_id)
					->manager(Notice::MANAGER_SYSTEM)
					->receiver($this->receiver_id)
					->action($this->controller,$this->action,$this->item_id)
					->key("{$this->controller}.{$this->action}.{$this->item_id}.{$this->receiver_id}")
					->content($cropped_content_string)
					->create();
			}

			if(!fx_me($this->author_id) && !fx_equal($this->author_id,$this->receiver_id)){
				$send_obj->theme('comments.send_notice_title')			// отправить автору комментария
					->sender($this->sender_id)
					->manager(Notice::MANAGER_SYSTEM)
					->receiver($this->author_id)
					->action($this->controller,$this->action,$this->item_id)
					->key("{$this->controller}.{$this->action}.{$this->item_id}.{$this->author_id}")
					->content($cropped_content_string)
					->create();
			}
			$send_obj->send();

			return $this;
		}






















	}














