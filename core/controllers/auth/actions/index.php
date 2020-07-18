<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;
	use Core\Controllers\Auth\Forms\Auth_Form;

	class Index extends Controller{

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

		/** @var array */
		public $index;

		public $auth_form;
		public $user_data;
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
			$this->auth_form = Auth_Form::getInstance('auth');

			$this->response->title('auth.title_index_action');
			$this->response->breadcrumb('login')
				->setValue('auth.title_index_action')
				->setLink('auth')
				->setIcon(null);
		}

		public function methodGet(){
			$this->auth_form->generateFieldsList();

			if($this->params->actions['index']['enable_captcha']){
				$this->auth_form->setCaptcha();
			}

			$this->form_fields_list = $this->auth_form->getFieldsList();

			return $this->response->controller('auth','index')
				->set('fields',$this->form_fields_list)
				->set('form',$this->auth_form->getFormAttributes())
				->set('errors',$this->auth_form->getErrors());
		}

		public function methodPost(){
			$this->auth_form->checkFieldsList();

			if($this->params->actions['index']['enable_captcha']){
				$this->auth_form->setCaptcha();
			}

			$this->form_fields_list = $this->auth_form->getFieldsList();

			if($this->auth_form->can()){
				$this->user_data = $this->model->getAuthDataByLogin($this->form_fields_list['login']['attributes']['value']);
				if($this->user_data){
					if(fx_equal($this->user_data['password'],fx_encode($this->form_fields_list['password']['attributes']['value']))){
						$this->user_data['groups'] = fx_arr($this->user_data['groups']);
						$this->user->auth($this->user_data,$this->form_fields_list['member_me']['attributes']['value']);
						return $this->redirect();
					}else{
						$this->form_fields_list['password']['errors'][] = fx_lang('auth.passwords_not_equal',array(
							'%input_password%'	=> $this->form_fields_list['password']['attributes']['value']
						));
					}
				}else{
					$this->form_fields_list['login']['errors'][] = fx_lang('auth.user_not_found',array(
						'%user_login%'	=> $this->form_fields_list['login']['attributes']['value']
					));
				}
			}

			return $this->response->controller('auth','index')
				->set('fields',$this->form_fields_list)
				->set('form',$this->auth_form->getFormAttributes())
				->set('errors',$this->auth_form->getErrors());
		}





















	}














