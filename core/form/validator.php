<?php

	/*
	 	$valid = new \Core\Form\Validator();
		$valid->nonCheckCSRF();
		$valid->setData($request->get('form'));
		$valid->checkCSRF();

		$valid->field('name')->required()->url()->domain()->float()->email()->min()->max();
		$valid->field('value')->required()->html_max()->html_min()->boolean();

		fx_die($valid->can() ? 'OK' : $valid->getErrors());
	*/

	namespace Core\Form;

	class Validator{

		private $field;
		private $value;
		private $check_csrf=true;

		private $errors = array();
		private $data = array();

		public function getErrors(){
			return $this->errors;
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
			if(fx_csrf_equal()){
				return $this;
			}
			$this->errors['csrf'][] = fx_lang('fields.csrf_token_not_equal');
			return $this;
		}

		public function nonCheckCSRF(){
			$this->check_csrf = false;
		}

		public function field($field){
			$this->field = $field;
			return $this->value($this->field);
		}

		public function getValue($value){
			if(isset($this->data[$value])){
				return $this->data[$value];
			}
			return null;
		}

		public function value($value){
			if(isset($this->data[$value])){
				$this->value = $this->data[$value];
				return $this;
			}
			$this->value = null;
			return $this;
		}

		public function required($default=true){
			if(!$default){ return $this; }
			if(!empty($this->value)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.field_has_attr_required', array(
					'FIELD_NAME'	=> $this->field
				)
			);
			return $this;
		}

		public function min($default=6){
			if(mb_strlen($this->value)>=$default){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_min_length', array(
					'FIELD'	=> $this->field,
					'COUNT'	=> $default,
				)
			);
			return $this;
		}

		public function max($default=16){
			if(mb_strlen($this->value)<=$default){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_max_length', array(
					'FIELD'	=> $this->field,
					'COUNT'	=> $default,
				)
			);
			return $this;
		}

		public function html_min($default=6){
			if(mb_strlen(strip_tags($this->value))>=$default){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_min_length', array(
					'FIELD'	=> $this->field,
					'COUNT'	=> $default,
				)
			);
			return $this;
		}

		public function html_max($default=16){
			if(mb_strlen(strip_tags($this->value))<=$default){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_max_length', array(
					'FIELD'	=> $this->field,
					'COUNT'	=> $default,
				)
			);
			return $this;
		}

		public function mask($default="a-zA-Z0-9"){
			if(!$default){ return $this; }
			preg_match( "([{$default}]+)",$this->value,$result);
			if(isset($result[0]) && fx_equal($result[0],$this->value)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_mask', array(
					'FIELD'	=> $this->field,
					'MASK'	=> $default,
				)
			);
			return $this;
		}

		public function email($default=true){
			if(!$default){ return $this; }
			preg_match("/^[A-Za-zА-Яа-яЁё0-9\.\-\_]+\@[A-Za-zА-Яа-яЁё0-9\.\-\_]+.[A-Za-zА-Яа-яЁё0-9]$/u",$this->value,$result);
			if(isset($result[0]) && fx_equal($result[0],$this->value)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_email', array(
					'FIELD'	=> $this->field,
				)
			);
			return $this;
		}

		public function boolean($default=true){
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_BOOLEAN)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_boolean',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function domain($default=true){
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_DOMAIN)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_domain',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function float($default=true){
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_FLOAT)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_float',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function int($default=true){
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_INT)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_int',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function ip($default=true){
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_IP)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_ip',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function mac($default=true){
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_MAC)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_mac',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function regexp($default){
			if(filter_var($this->value,FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>$default)))){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_regexp',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function url($default=true){
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_URL)){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_url',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function lower_letters($default=true){
			if(!$default){ return $this; }
			preg_match("#[a-z]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_lower_letters',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function upper_letters($default=true){
			if(!$default){ return $this; }
			preg_match("#[A-Z]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_upper_letters',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function numeric($default=true){
			if(!$default){ return $this; }
			preg_match("#[0-9]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_numeric',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function symbols($default=true){
			if(!$default){ return $this; }
			preg_match("/[\!\@\#\$\%\^\&\*\(\)\_\+\=\-\\]\[\~\`\|\}\{\'\:\"\;\?\/\.\,\<\>]/",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_symbols',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function lower_cyrillic($default=true){
			if(!$default){ return $this; }
			preg_match("#([а-яёъэ]+)#u",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_lower_cyrillic',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}

		public function upper_cyrillic($default=true){
			if(!$default){ return $this; }
			preg_match("#([А-ЯЁЪЭ]+)#u",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->errors[$this->field][] = fx_lang('fields.error_field_not_upper_cyrillic',array(
				'FIELD'	=> $this->field,
			));
			return $this;
		}





















	}














