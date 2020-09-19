<?php

	/*
		use Core\Classes\Form\Form;

		$fields_array = array(
			array(
				'form'		=> array(
					'enctype'	=> '',
					'id'		=> 'forma',
					'action'	=> '/url/to/send/form'
				),
				'field'		=> 'img_field',
				'type'		=> 'file',
				'field_type'=> 'image',
				'id'		=> 'image_field',
				'required'	=> true,
				'float'		=> true,
				'data'		=> array(
					array(
						'key'	=> 'dss',
						'value'	=> 'fds'
					),
					array(
						'key'	=> 'ds',
						'value'	=> 'fd'
					)
				),
				'attr'		=> 'simple',
				'files'	=> array(
					'single'	=> true,
					'accept'	=> array(
						'type'		=> 'image',
						'sub_type'	=> array('jpg','gif','pngs')
					),
					'max_size' => 1045,
					'min_size' => 3333333333
				)
			),
			array(
				'field'		=> 'field_name1',
				'type'		=> 'numeric',
				'field_type'=> 'text',
				'id'		=> 'field_name1',
				'required'	=> true,
				'numeric'	=> true
			),
			array(
				'field'		=> 'field_name2',
				'type'		=> 'ip',
				'field_type'=> 'text',
				'id'		=> 'field_name2',
				'required'	=> true,
			),
			array(
				'field'		=> 'field_name3',
				'type'		=> 'mac',
				'field_type'=> 'text',
				'id'		=> 'field_name3',
				'required'	=> true,
			),
		);
		$form = new Form();
		$form->csrf(1);
		$form->validate(1);
		$form->setData($request->getArray('form'));
		$form->setArrayFields($fields_array);
		$form->checkArrayFields();

		fx_die($form->can() ? $form->getFieldsList() : array(
			$form->getFieldsList(),
			$form->getErrors(),
			$form->getFormAttributes(),
			fx_encode($user->getCSRFToken())
		));
	*/

	namespace Core\Classes\Form;

	use Core\Classes\Session;
	use Core\Classes\Language;
	use Core\Controllers\Home\Model;

	class Form extends Validator{

		protected $validator_interface;

		protected $fields_array;

		public function __construct(){
			parent::__construct();
			$this->validator_interface = $this;
		}

		public function setArrayFields($fields_array){
			$this->fields_array = $fields_array;
			return $this;
		}

		public function checkArrayFields(){
			foreach($this->fields_array as $field){
				$this->checkArrayItemField($field)
					->mergeAttributes();
			}
			return $this;
		}

		public function checkArrayItemField($field_value){
			foreach($field_value as $key=>$value){
				if(method_exists($this,$key)){
					call_user_func_array(array($this,$key),array($value));
				}else{
					$this->setAttribute($key,$value);
				}
			}
			return $this;
		}

		public function setCaptcha(){
			if($this->validate_status){
				$captcha_data = $this->session->get('captcha',Session::PREFIX_CONF);
				if($captcha_data){
					if(fx_equal($captcha_data['word'],mb_strtoupper($this->value))){
						$this->makeCaptcha();
						return $this;
					}
					$this->setError(fx_lang('fields.captcha_not_equal'),$this->field);
					$this->makeCaptcha();
					return $this;
				}
				$this->setError(fx_lang('fields.captcha_not_found'),$this->field);
			}
			$this->makeCaptcha();
			return $this;
		}

		public function captcha(){
			$this->field('captcha');
			$this->setAttribute('required',true);
			$this->setAttribute('autocomplete','off');
			$this->setParams('field_type','captcha');
			$this->setParams('field_sets_field_class','col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12');
			return $this->setCaptcha();
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
			$this->setParams('captcha_image',$captcha_image);
			return $captcha_image;
		}

		public function setFilter($form_action,$input_data){
			$this->setData($input_data);
			$this->csrf(false);
			$this->validate(true);
			$this->form(function(Form $form)use($form_action){
				$form->setFormAction($form_action);
				$form->setFormMethod('GET');
				$form->setFormAutoComplete('off');
				$form->setFormName('filter');
			});
			return $this;
		}

		public function filtrate(callable $callback=null){
			if($callback){
				call_user_func($callback);
			}
			foreach($this->fields_list as $key=>$value){
				if($this->fields_list[$key]['attributes']['params']['filter_validation'] &&
					$value['attributes']['value'] && !fx_equal($key,'geo')){
					$this->filter_query .= " AND `{$key}` {$this->fields_list[$key]['attributes']['params']['filter_validation']} %{$key}%";
					$this->filter_data_to_replace["%{$key}%"] = $this->makeFilter($this->fields_list[$key]['attributes']['params']['filter_validation'],$value['attributes']['value']);
				}
			}
			return $this;
		}

		private function makeFilter($operator,$value){
			switch($operator){
				case(fx_equal($operator,'LIKE')):
					return "%{$value}%";
					break;
				case(fx_equal($operator,'=')):
					return $value;
					break;
				case(fx_equal($operator,'!=')):
					return $value;
					break;
				default:
					return $value;
					break;
			}
		}

		public function geo_filter($country_field_name,$region_field_name,$city_field_name){
			if(($country_value = $this->getValue($country_field_name))){
				$this->filter_query .= " AND {$country_field_name}=%country%";
				$this->filter_data_to_replace["%country%"] = $country_value;
			}
			if(($region_value = $this->getValue($region_field_name))){
				$this->filter_query .= " AND {$region_field_name}=%region%";
				$this->filter_data_to_replace["%region%"] = $region_value;
			}
			if(($city_value = $this->getValue($city_field_name))){
				$this->filter_query .= " AND {$city_field_name}=%city%";
				$this->filter_data_to_replace["%city%"] = $city_value;
			}

			return $this->geo($country_field_name,$region_field_name,$city_field_name);
		}

		public function geo($country_field_name,$region_field_name,$city_field_name,callable $callback=null){
			$lang_key = Language::getInstance()->getLanguageKey();

			$this->field('geo')
				->field_type('geo')
				->field_sets('geo_info');

			if($callback){
				call_user_func($callback,$this);
			}

			$country_value = $this->getValue($country_field_name);
			$region_value = $this->getValue($region_field_name);
			$city_value = $this->getValue($city_field_name);

			$geo_info = Model::getInstance()->getGeoByIds($country_value,$region_value,$city_value);

			$this->setParams('country',array(
				'id'	=> $country_value,
				'name'	=> $this->form_attributes['name'] ? "{$this->form_attributes['name']}[{$country_field_name}]" : $country_field_name,
				'value'	=> $geo_info["g_title_{$lang_key}"],
			));
			$this->setParams('region',array(
				'id'	=> $region_value,
				'name'	=> $this->form_attributes['name'] ? "{$this->form_attributes['name']}[{$region_field_name}]" : $region_field_name,
				'value'	=> $geo_info["gr_title_{$lang_key}"],
			));
			$this->setParams('city',array(
				'id'	=> $city_value,
				'name'	=> $this->form_attributes['name'] ? "{$this->form_attributes['name']}[{$city_field_name}]" : $city_field_name,
				'value'	=> (!$geo_info['gc_area']?$geo_info["gc_title_{$lang_key}"]:"{$geo_info["gc_title_{$lang_key}"]}, ") . $geo_info['gc_area'],
			));

			return $this;
		}

/*
		public function setAvatar(){}
		public function setCheckbox(){}
		public function setComment(){}
		public function setFile_name(){}
		public function setFiles(){}
		public function setHidden(){}
		public function setImage(){}
		public function setImages(){}
		public function setMessage(){}
		public function setPost(){}
		public function setSelect(){}
		public function setSubmit(){}
		public function setSwitch(){}
		public function setTextarea(){}
		public function setText(){}
		public function setPassword(){}
		public function setEmail(){}
		public function setNumber(){}
*/

		public function getQuery(){
			return $this->filter_query;
		}

		public function getReplacingData(){
			return $this->filter_data_to_replace;
		}
















	}














