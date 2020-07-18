<?php

	namespace Core\Classes\Forms;

	use Core\Classes\Config;
	use Core\Classes\Session;

	use Core\Classes\Forms\Interfaces\Attributes as AttributesInterface;
	use Core\Classes\Forms\Interfaces\Fields as FieldsInterface;
	use Core\Classes\Forms\Interfaces\Form as FormInterface;
	use Core\Classes\Forms\Interfaces\Params as ParamsInterface;
	use Core\Classes\Forms\Interfaces\Validator as ValidatorInterface;
	use Core\Classes\Forms\Interfaces\Field;

	class Form implements AttributesInterface,FieldsInterface,FormInterface,ParamsInterface,ValidatorInterface,Field{

		use Params;
		use Fields;
		use Validator;
		use Attributes;

		/** @var Field|FieldsInterface */
		protected $form_interface;

		const CSRF_TOKEN_EQUAL = 'equal';
		const CSRF_TOKEN_NOT_FOUND = 'not_found';
		const CSRF_TOKEN_NOT_EQUAL = 'not_equal';

		protected $field_name;
		protected $field;
		protected $value;

		protected $check_csrf=true;
		protected $validate_status = false;

		protected $data = array();
		protected $fields_list = array();

		protected $access;

		protected $default_attributes = array(
			'attributes'=> array(
				'autocomplete' => 'on',
				'placeholder' => null,
				'required' => null,
				'readonly' => null,
				'title' => null,
				'class' => 'form-control',
				'name' => null,
				'type' => 'text',			// аттрибут поля 'type'
				'value' =>null,
				'min' => null,
				'max' => null,
				'id' => null,
			),
			'params'	=> array(
				'show_in_form'		=> true,
				'show_in_item'		=> true,
				'show_in_filter'	=> true,
				'show_label_in_form'=> true,
				'show_title_in_form'=> true,
				'show_validation'	=> true,
				'field_sets'		=> 'main_field_set',
				'field_sets_field_class'=> 'col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12',
				'form_position'		=> null,
				'filter_position'	=> null,
				'item_position'		=> null,
				'filter_validation'	=> null,	// string [ = | != | > | < | <= | >= ]
				'filter_query'		=> null,	// return "where [field] [filter_validation] [value]";
				'render_type'		=> 'text',	// вывод рендинга в item
				'field_type' 		=> 'simple',// вывод рендинга в form
				'label' 			=> null,
				'description' 		=> null,
				'validate_status' 		=> null,
			),
			'errors'	=> array(

			)
		);

		protected $default_files_attributes = array(
			'min_size'	=> null,
			'max_size'	=> null,
			'accept'	=> null,
			'multiple'	=> null,
		);

		protected $form_attributes = array(
			'accept-charset'	=> 'UTF-8',
			'action'			=> '',
			'autocomplete'		=> 'on', // off
			'enctype'			=> 'application/x-www-form-urlencoded', /*
																			multipart/form-data
																			text/plain
																		*/
			'method'			=> 'POST', // GET
			'name'				=> '',
			'novalidate'		=> '',	// novalidate
			'rel'				=> '', /*
											external
											help
											license
											next
											nofollow
											noopener
											noreferrer
											opener
											prev
											search
										*/
			'target'			=> '', /*
											_blank
											_self
											_parent
											_top
										*/
			'class'				=> 'simple-form-class',
			'id'				=> 'simple-form-id',
			'title'				=> '',
			'submit'			=> null,
		);

		protected $session;
		protected $config;

		public function __construct(){
			$this->form_interface = $this;
			$this->config = Config::getInstance();
			$this->session = Session::getInstance();
			$this->setCSRFField();
		}

		private function setCSRFField(){
			$this->setField($this->config->session['csrf_key_name']);
			$this->fields_list[$this->field]['attributes']['type'] = 'hidden';
			$this->fields_list[$this->field]['attributes']['class'] = $this->config->session['csrf_key_name'];
			$this->fields_list[$this->field]['attributes']['value'] = fx_csrf();
			$this->fields_list[$this->field]['attributes']['required'] = true;
			$this->fields_list[$this->field]['params']['field_sets'] = 'csrf';
			$this->fields_list[$this->field]['params']['field_type'] = 'hidden';
			$this->fields_list[$this->field]['params']['field_sets_field_class'] = 'm-0 csrf';
			return $this;
		}
		private function runCallbackOrArrayFunction($callback_or_array){
			if(is_callable($callback_or_array)){
				call_user_func($callback_or_array,$this);
			}else{
				foreach($callback_or_array as $method => $param){
					call_user_func(array($this,$method),$param);
				}
			}
			return $this;
		}

		public function form($callback){
			call_user_func($callback,$this);
			return $this;
		}
		public function field($callback){
			call_user_func($callback,$this);
			return $this;
		}
		public function params($callback){
			call_user_func($callback,$this);
			return $this;
		}
		public function check($callback){
			if($this->validate_status){
				call_user_func($callback,$this);
			}
			return $this;
		}

		public function setFormFieldsFromFiedsArray($array_fields){
			foreach($array_fields as $field){
				$this->setField($field['field_name']);
				foreach($field as $method=>$param){
					call_user_func(array($this,$method),$param);
				}
			}
			return $this;
		}
		public function setData($data_array){
			$this->data = $data_array;
			return $this;
		}
		public function setField($name){
			$this->field = $name;
			$this->fields_list[$this->field] = $this->default_attributes;
			$this->fields_list[$this->field]['attributes']['name'] = $name;
			return $this->field_value();
		}
		public function setError($error){
			$this->access = false;
			$this->fields_list[$this->field]['errors'][] = $error;
			return $this;
		}
		public function validation($status){
			$this->validate_status = $status;
			return $this;
		}
		public function csrf(){
			$this->field = $this->config->session['csrf_key_name'];
			$csrf_result_checking = fx_csrf_equal($this->field);
			if(fx_equal($csrf_result_checking,self::CSRF_TOKEN_EQUAL)){
				return $this;
			}
			$this->setError(fx_lang("fields.csrf_token_error_{$csrf_result_checking}"));
			return $this;
		}

		public function getForm(){
			return $this->form_attributes;
		}
		public function getFields(){
			return $this->fields_list;
		}
		public function granted(){
			return $this->access;
		}
		public function denied(){
			return !$this->access;
		}

		public function form_charset($value){
			$this->form_attributes['accept-charset'] = $value;
			return $this;
		}
		public function form_action($value){
			$this->form_attributes['action'] = $value;
			return $this;
		}
		public function form_autocomplete($value){
			$this->form_attributes['autocomplete'] = $value;
			return $this;
		}
		public function form_enctype($value){
			$this->form_attributes['enctype'] = $value;
			return $this;
		}
		public function form_method($value){
			$this->form_attributes['method'] = $value;
			return $this;
		}
		public function form_name($value){
			$this->form_attributes['name'] = $value;
			return $this;
		}
		public function form_novalidate($value){
			$this->form_attributes['novalidate'] = $value;
			return $this;
		}
		public function form_rel($value){
			$this->form_attributes['rel'] = $value;
			return $this;
		}
		public function form_target($value){
			$this->form_attributes['target'] = $value;
			return $this;
		}
		public function form_class($value){
			$this->form_attributes['class'] = $value;
			return $this;
		}
		public function form_id($value){
			$this->form_attributes['id'] = $value;
			return $this;
		}
		public function form_title($value){
			$this->form_attributes['title'] = $value;
			return $this;
		}

		protected function preg_match($pattern,$subject,&$matches,$flags=0,$offset=0){
			if(!is_string($this->value)){
				return $this->setError(fx_lang('fields.error_field_not_string', array(
						'FIELD'	=> $this->field_name,
					)
				));
			}
			preg_match($pattern,$subject,$matches,$flags,$offset);
			return $matches;
		}

		public function checkCaptcha(){
			if($this->validate_status){
				$captcha_data = $this->session->get('captcha',Session::PREFIX_CONF);
				if($captcha_data){
					if(fx_equal($captcha_data['word'],mb_strtoupper($this->value))){
						$this->makeCaptcha();
						return $this;
					}
					$this->setError(fx_lang('fields.captcha_not_equal'));
					$this->makeCaptcha();
					return $this;
				}
				$this->setError(fx_lang('fields.captcha_not_found'));
			}
			$this->makeCaptcha();
			return $this;
		}

		public function captcha(){
			$this->setField('captcha');
			$this->fields_list[$this->field]['attributes']['required'] = true;
			$this->fields_list[$this->field]['params']['field_type'] = 'captcha';
			$this->fields_list[$this->field]['params']['field_sets_field_class'] = 'col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12';
			return $this->checkCaptcha();
		}

		public function makeCaptcha(){
			$captcha_type = 'png';
			$captcha_length = rand(5,8);
			$captcha_word = mb_strtoupper(fx_gen($captcha_length));
			$captcha_size = rand(12,36);
			$captcha_image = fx_make_captcha($captcha_word,$captcha_size,$captcha_type);
			$this->session->set('captcha',array(
				'word'	=> $captcha_word,
				'length'=> $captcha_length,
				'type'	=> $captcha_type,
				'size'	=> $captcha_size,
			),Session::PREFIX_CONF);
			$this->fields_list[$this->field]['params']['captcha_image'] = $captcha_image;
			return $captcha_image;
		}














	}