<?php

	namespace Core\Controllers\Comments\Widgets;

	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Comments\Forms\Add_Comment;
	use Core\Controllers\Comments\Model;
	use Core\Widgets\Paginate;

	/**
	 *
	 *
	 * Class Comments
	 * @package Core\Controllers\Comments\Widgets
	 */
	class Comments{

		protected $params;
		protected $default_props = array(
			'w_id'				=> 1,
			'w_class'			=> self::class,
			'w_method'			=> 'set',
			'w_status'			=> 1,
			'w_template'		=> 'controllers/comments/widgets/comments',
			'w_date_created' 	=> null,
			'w_date_updated' 	=> null,
			'w_date_deleted' 	=> null,
			'wa_id'				=> 4,
			'wa_widget_id'		=> 1,
			'wa_name'			=> 'comments',
			'wa_title'			=> 'comments.comments_widget_title',
			'wa_css_class'		=> 0,
			'wa_css_class_title'=> 0,
			'wa_css_class_body'	=> 0,
			'wa_show_title'		=> 1,
			'wa_unite_prev'		=> 0,
			'wa_status'			=> 1,
			'wa_position'		=> 'after_content',
			'wa_ordering'		=> -1000,
			'wa_template'		=> 'controllers/comments/widgets/comments',
			'wa_groups_enabled' => null,
			'wa_groups_disabled'=> null,
			'wa_pages_enabled' 	=> null,
			'wa_pages_disabled' => null,
			'wa_date_created' 	=> null,
			'wa_date_updated' 	=> null,
			'wa_date_deleted' 	=> null,
		);

		private $author_id;		// сессия
		private $receiver_id;	// вручную

		private $controller;	// вручную из экшна записи
		private $action = null;	// вручную из экшна записи
		private $item_id;		// вручную из экшна записи

		private $send_form;

		private $comments_list;
		private $total_comments;
		private $pagination_link;

		private $response;
		private $request;
		private $model;

		private $limit;
		private $offset;

		/**
		 * @usage
		 *
		 * $comments = Comments::add($this->limit,$this->offset);
			$comments->controller('blog')
			->action('item')
			->item_id($this->post_data['b_id'])
			->paginate(array('blog','item',$this->item_id))
			->author($this->user_id)
			->receiver($this->post_data['b_user_id'])
			->call(function()use($comments){
				$comments->setProperty('total_comments',0);
				$comments->setProperty('comments_list',array());
			})
			->set();
		 *
		 * @param $property_name
		 * @param $property_value
		 * @return $this
		 */
		public function setProperty($property_name,$property_value){
			$this->{$property_name} = $property_value;
			return $this;
		}

		public static function add($limit = 30,$offset = 0){
			return new self($limit,$offset);
		}

		public function __construct($limit,$offset){
			$this->limit = $limit;
			$this->offset = $offset;

			$this->params = $this->default_props;
			$this->response = Response::getInstance();
			$this->request = Request::getInstance();
			$this->model = Model::getInstance();

			$this->send_form = Add_Comment::getInstance();
		}

		public function setProp($key,$value){
			$this->default_props[$key] = $this->params[$key] = $value;
			return $this;
		}

		public function props(array $new_props){
			$this->default_props = $this->params = array_merge($this->default_props,$new_props);
			return $this;
		}

		public function controller($controller){
			$this->controller = $controller;
			return $this;
		}
		public function action($action){
			$this->action = $action;
			return $this;
		}
		public function item_id($item_id){
			$this->item_id = $item_id;
			return $this;
		}
		public function author($author_id){
			$this->author_id = $author_id;
			return $this;
		}
		public function receiver($receiver_id){
			$this->receiver_id = $receiver_id;
			return $this;
		}
		public function paginate(array $link){
			$this->pagination_link = $link;
			return $this;
		}

		public function call(callable $callback_function){
			call_user_func($callback_function);
			return $this;
		}

		public function set(){

			if($this->total_comments === null){
				$this->getCountComments();
			}

			if($this->comments_list === null){
				$this->getCommentsList();
			}

			$this->addPagination();

			$this->send_form->generateFieldsList($this->controller, $this->action, $this->item_id, $this->receiver_id);

			$this->response->widget($this->params)
				->set('data',array(
					'comments'		=> $this->comments_list,
					'total'			=> $this->total_comments,
					'controller'	=> $this->controller,
					'action'		=> $this->action,
					'item_id'		=> $this->item_id,
					'limit'			=> $this->limit,
					'offset'		=> $this->offset,
					'author_id'		=> $this->author_id,
					'receiver_id'	=> $this->receiver_id,
					'form'			=> array(
						'form'		=> $this->send_form->getFormAttributes(),
						'fields'	=> $this->send_form->getFieldsList(),
						'errors'	=> $this->send_form->getErrors(),
					)
				))
				->set('params',$this->params)
				->add();
			return true;
		}


		private function getCountComments(){
			$this->total_comments = $this->model->countCommentsByItem(
				$this->controller,
				$this->action,
				$this->item_id
			);
			return $this;
		}
		private function getCommentsList(){
			$this->comments_list = $this->model->getCommentsByItem(
				$this->controller,
				$this->action,
				$this->item_id,
				$this->limit,
				$this->offset
			);
			return $this;
		}

		private function addPagination(){
			Paginate::add()->total($this->total_comments)
				->limit($this->limit)
				->offset($this->offset)
				->link($this->pagination_link)
				->set();
			return $this;
		}

	}