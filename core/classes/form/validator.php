<?php

	/*
		use Core\Classes\Form\Interfaces\Checkers;
		use Core\Classes\Form\Form;

		$new_form = Form::getStaticValidatorInterface();
		$new_form
			->setFormName('')
			->setData($request->getArray(''))
			->csrf(1)
			->validate(1)
		;

		$new_form->name('field_name')
			->id('field_name_id')
			->label('field_name_label')
			->placeholder('field_name_placeholder')
			->class('field_name_class')
			->type('field_name_type')
			->title('field_name_title')
			->data('field_name_key','field_name_value')
			->data('id',35)
			->check(function(Checkers $validator){
				$validator->required();
				$validator->min(2);
			});

	----------------------------------------------------------------------------------------------

		use Core\Classes\Form\Interfaces\Validator;
		use Core\Classes\Form\Interfaces\Checkers;
		use Core\Classes\Form\Form;

		$form = Form::getStaticValidatorInterface(function(Validator $validator){
			$validator
				->csrf(1)
				->validate(1)
				->setFormName('test')
				->setData(Request::getInstance()->getArray('test'));
			$validator
				->name('field')
				->class('class')
				->title('title')
				->id('id')
				->type('checkbox')
				->field_type('checkbox')
				->placeholder('holder, place')
				->label('label')
				->data('key','value')
				->data('key1','value1')
				->data('key2','value2')
				->setAttribute('attr','simple')
				->check(function(Checkers $checkers){
					$checkers->required()->int()->email()->numeric()->boolean();
				});
			return $validator;
		});

		fx_die($form->can() ? $form->getFieldsList() : array(
			$form->getFieldsList(),
			$form->getErrors(),
			fx_encode($user->getCSRFToken())
		));

	*/

	namespace Core\Classes\Form;

	use Core\Classes\Config;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Validator as ValidatorInterface;

	class Validator implements ValidatorInterface, Checkers{

		protected $config;

		protected $field;
		protected $value;
		protected $check_csrf=true;

		protected $validate_status = false;
		protected $errors = array();
		protected $data = array();
		protected $fields_list = array();
		protected $form_name;
		protected $default_attributes = array(
			'placeholder' => null,
			'field_type' => 'text',
			'required' => null,
			'html_min' => null,
			'html_max' => null,
			'label' => null,
			'title' => null,
			'class' => null,
			'name' => null,
			'type' => 'text',
			'value' =>null,
			'min' => null,
			'max' => null,
			'id' => null,
		);

		/**
		 * @param null $callback_function
		 * @return ValidatorInterface
		 */
		public static function getStaticValidatorInterface($callback_function=null){
			if($callback_function){
				return call_user_func($callback_function, new self());
			}
			return new self();
		}

		/**
		 * @param null $callback_function
		 * @return ValidatorInterface
		 */
		public function getDynamicValidatorInterface($callback_function=null){
			if($callback_function){
				return call_user_func($callback_function, new self());
			}
			return new self();
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->setCSRFAttributes();
		}
		public function setDefaultFieldsAttributes(array $attributes){
			$this->default_attributes = $attributes;
			return $this;
		}

		public function setFormName($form_name){
			$this->form_name = $form_name;
			return $this;
		}

		public function validate($status=true){
			$this->setValidationStatus($status);
			$this->checkCSRF();
			return $this;
		}
		public function getAttribute($field_name,$attribute_key='value'){
			if(isset($this->fields_list[$field_name]['attributes'][$attribute_key])){
				return $this->fields_list[$field_name]['attributes'][$attribute_key];
			}
			return null;
		}
		public function setAttribute($attribute_key,$attribute_value){
			$this->fields_list[$this->field]['attributes'][$attribute_key] = $attribute_value;
			return $this;
		}

		public function value($value){
			$this->value = null;
			if(isset($this->data[$value])){
				$this->value = $this->data[$value];
			}
			return $this->setAttribute(__FUNCTION__,$this->value);
		}

		public function setError($error_data_value){
			$this->errors[$this->field][] = $this->fields_list[$this->field]['errors'][] = $error_data_value;
			return $this;
		}
		public function getErrors(){
			return $this->errors;
		}
		public function getFieldsList(){
			return $this->fields_list;
		}
		public function can(){
			if(!$this->errors){
				return true;
			}
			return false;
		}
		public function setData($data_array){
			$this->data = $data_array;
			return $this;
		}
		public function csrf($check_status = true){
			$this->check_csrf = $check_status;
			return $this;
		}
		public function getValue($value_key){
			if(isset($this->data[$value_key])){
				return $this->data[$value_key];
			}
			return null;
		}
		public function name($field){
			$this->field = $field;
			$this->setAttribute(__FUNCTION__,$this->field);
			return $this->value($this->field);
		}

		public function class($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function placeholder($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function label($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function title($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function id($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function type($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function field_type($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}

		public function data($data,$value=null){
			if(is_array($data)){
				foreach($data as $item){
					$this->setAttribute("data-{$item['key']}",$item['value']);
				}
				return $this;
			}
			return $this->setAttribute("data-{$data}",$value);
		}
		public function check($callback_function=null){
			if($callback_function){
				call_user_func($callback_function,$this);
			}
			return $this->mergeAttributes();
		}

		public function mergeAttributes(){
			$this->fields_list[$this->field]['attributes'] = array_merge($this->default_attributes,$this->fields_list[$this->field]['attributes']);
			return $this;
		}

		public function required($default=true){
			$this->setAttribute(__FUNCTION__,$default);
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(!empty($this->value)){
				return $this;
			}
			$this->setError(fx_lang('fields.field_has_attr_required', array(
					'FIELD_NAME'	=> $this->field
				)
			));
			return $this;
		}

		public function min($default=6){
			$this->setAttribute(__FUNCTION__,$default);
			if(!$this->validate_status){ return $this; }
			if(mb_strlen($this->value)>=$default){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_min_length', array(
					'FIELD'	=> $this->field,
					'COUNT'	=> $default,
				)
			));
			return $this;
		}

		public function max($default=16){
			$this->setAttribute(__FUNCTION__,$default);
			if(!$this->validate_status){ return $this; }
			if(mb_strlen($this->value)<=$default){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_max_length', array(
					'FIELD'	=> $this->field,
					'COUNT'	=> $default,
				)
			));
			return $this;
		}

		public function html_min($default=6){
			$this->setAttribute(__FUNCTION__,$default);
			if(!$this->validate_status){ return $this; }
			if(mb_strlen(strip_tags($this->value))>=$default){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_min_length', array(
					'FIELD'	=> $this->field,
					'COUNT'	=> $default,
				)
			));
			return $this;
		}

		public function html_max($default=16){
			$this->setAttribute(__FUNCTION__,$default);
			if(!$this->validate_status){ return $this; }
			if(mb_strlen(strip_tags($this->value))<=$default){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_max_length', array(
					'FIELD'	=> $this->field,
					'COUNT'	=> $default,
				)
			));
			return $this;
		}

		public function mask($default="a-zA-Z0-9"){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			preg_match( "([{$default}]+)",$this->value,$result);
			if(isset($result[0]) && fx_equal($result[0],$this->value)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_mask', array(
					'FIELD'	=> $this->field,
					'MASK'	=> $default,
				)
			));
			return $this;
		}

		public function email($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			preg_match("/^[A-Za-zА-Яа-яЁё0-9\.\-\_]+\@[A-Za-zА-Яа-яЁё0-9\.\-\_]+.[A-Za-zА-Яа-яЁё0-9]$/u",$this->value,$result);
			if(isset($result[0]) && fx_equal($result[0],$this->value)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_email', array(
					'FIELD'	=> $this->field,
				)
			));
			return $this;
		}

		public function boolean($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_BOOLEAN)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_boolean',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function domain($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_DOMAIN)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_domain',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function float($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_FLOAT)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_float',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function int($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_INT)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_int',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function ip($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_IP)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_ip',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function mac($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_MAC)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_mac',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function regexp($default){
			if(!$this->validate_status){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>$default)))){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_regexp',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function url($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_URL)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_url',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function lower_letters($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			preg_match("#[a-z]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_lower_letters',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function upper_letters($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			preg_match("#[A-Z]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_upper_letters',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function numeric($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			preg_match("#[0-9]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_numeric',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function symbols($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			preg_match("/[\!\@\#\$\%\^\&\*\(\)\_\+\=\-\\]\[\~\`\|\}\{\'\:\"\;\?\/\.\,\<\>]/",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_symbols',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function lower_cyrillic($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			preg_match("#([а-яёъэ]+)#u",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_lower_cyrillic',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		public function upper_cyrillic($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			preg_match("#([А-ЯЁЪЭ]+)#u",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_upper_cyrillic',array(
				'FIELD'	=> $this->field,
			)));
			return $this;
		}

		protected function setCSRFAttributes(){
			$this->name($this->config->session['csrf_key_name']);
			$this->setAttribute('type','hidden');
			$this->setAttribute('field_type','hidden');
			$this->setAttribute('value',fx_csrf());
			$this->setAttribute('required',true);
			$this->mergeAttributes();
			return $this;
		}
		protected function checkCSRF(){
			if(!$this->validate_status){ return $this; }
			if(!$this->check_csrf){ return $this; }
			$this->field = $this->config->session['csrf_key_name'];
			if(fx_csrf_equal($this->field)){
				return $this;
			}
			$this->setError(fx_lang('fields.csrf_token_not_equal'));
			return $this;
		}
		protected function setValidationStatus($status){
			$this->validate_status = $status;
			return $this;
		}



















	}














