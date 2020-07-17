<?php

	/*
		use Core\Form\Interfaces\Checkers;
		use Core\Form\Form;

		$new_form = Form::getStaticValidatorInterface();
		$new_form
			->setFormName('form')
			->setData($request->get('form'))
			->nonCheckCSRF()
			->runFieldsValidation(1)
	//			->checkCSRF()
		;

		$new_form->name('field_name')
			->id('field_name_id')
			->label('field_name_label')
			->placeholder('field_name_placeholder')
			->class('field_name_class')
			->type('field_name_type')
			->title('field_name_title')
			->data('field_name_key','field_name_value')
			->check(function(Checkers $validator){
				$validator->required();
				$validator->min(1);
			});

		fx_die(($new_form->can() ? $new_form->getFieldsList() : $new_form->getFieldsList()),fx_encode($user->getCSRFToken()));
	*/

	namespace Core\Form;

	use Core\Classes\Config;
	use Core\Form\Interfaces\Checkers;
	use Core\Form\Interfaces\Validator as ValidatorInterface;

	class Validator implements ValidatorInterface, Checkers{

		protected $config;

		protected $field;
		protected $value;
		protected $check_csrf=true;

		protected $validate_fields = false;
		protected $errors = array();
		protected $data = array();
		protected $fields_list = array();
		protected $form_name;

		/** @return ValidatorInterface */
		public static function getStaticValidatorInterface(){
			return new self();
		}

		/** @return ValidatorInterface */
		public function getDynamicValidatorInterface(){
			return $this;
		}

		public function __construct(){
			$this->config = Config::getInstance();
		}

		public function setFormName($form_name){
			$this->form_name = $form_name;
			return $this;
		}

		public function runFieldsValidation($status=true){
			$this->validate_fields = $status;
			return $this;
		}

		public function setAttribute($attribute_key,$attribute_value){
			$this->fields_list[$this->field][$attribute_key] = $attribute_value;
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
		public function checkCSRF(){
			if(!$this->check_csrf){ return $this; }
			$this->field = $this->config->session['csrf_key_name'];
			if(fx_csrf_equal($this->field)){
				return $this;
			}
			$this->setError(fx_lang('fields.csrf_token_not_equal'));
			return $this;
		}
		public function nonCheckCSRF(){
			$this->check_csrf = false;
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
				return $this->setAttribute("data-{$data['key']}",$data['value']);
			}
			return $this->setAttribute("data-{$data}",$value);
		}
		public function check($callback_function=null){
			if($callback_function && $this->validate_fields){
				call_user_func($callback_function,$this);
			}
			return $this;
		}

		public function required($default=true){
			$this->setAttribute(__FUNCTION__,$default);
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




















	}














