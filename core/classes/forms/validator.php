<?php

	namespace Core\Classes\Forms;

	trait Validator{

		public function validator_required($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(empty($this->value)){
				$this->setError(fx_lang('fields.field_has_attr_required', array(
						'%field%'	=> $this->field_name
					)
				));
			}
			return $this;
		}
		public function validator_min($default=6){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(mb_strlen($this->value)>=$default){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_min_length', array(
					'%field%'	=> $this->field_name,
					'%count%'	=> $default,
				)
			));
			return $this;
		}
		public function validator_max($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(mb_strlen($this->value)<=$default){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_max_length', array(
					'%field%'	=> $this->field_name,
					'%count%'	=> $default,
				)
			));
			return $this;
		}
		public function validator_email($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("/^[A-Za-zА-Яа-яЁё0-9\.\-\_]+\@[A-Za-zА-Яа-яЁё0-9\.\-\_]+.[A-Za-zА-Яа-яЁё0-9]$/u",$this->value,$result);
			if(isset($result[0]) && fx_equal($result[0],$this->value)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_email', array(
					'%field%'	=> $this->field_name,
				)
			));
			return $this;
		}
		public function validator_password($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->validator_lower($default);
			$this->validator_upper($default);
			$this->validator_numeric($default);
			$this->validator_symbols('\!\@\#\$\%\^\&\*\(\)\-\=\_\+');
			return $this;
		}
		public function validator_numeric($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#[0-9]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_numeric',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_int($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_INT)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_int',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_ip($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_IP)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_ip',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_mac($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_MAC)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_mac',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_boolean($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_BOOLEAN)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_boolean',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_domain($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_DOMAIN)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_domain',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_float($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_FLOAT)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_float',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_regexp($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>$default)))){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_regexp',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_url($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			if(filter_var($this->value,FILTER_VALIDATE_URL)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_url',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_lower($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#[a-z]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_lower_letters',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_upper($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#[A-Z]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_upper_letters',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_symbols($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#[{$default}]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_symbols',array(
				'%field%'		=> $this->field_name,
				'%pattern%'	=> stripslashes($default),
			)));
			return $this;
		}
		public function validator_lower_cyr($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#([а-яёъэ]+)#u",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_lower_cyrillic',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}
		public function validator_upper_cyr($default){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#([А-ЯЁЪЭ]+)#u",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_upper_cyrillic',array(
				'%field%'	=> $this->field_name,
			)));
			return $this;
		}



















	}














