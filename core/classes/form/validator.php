<?php
	/*
		use Core\Classes\Form\Interfaces\Checkers;
		use Core\Classes\Form\Interfaces\Multiple;
		use Core\Classes\Form\Form;
		use Core\Classes\Form\Interfaces\Form as FormInterface;

		$new_form = Form::getStaticValidatorInterface();
		$new_form->setData($request->getArray(''))
			->csrf(1)
			->validate(1);
		$new_form->form(function(FormInterface $form){
			$form->setFormEnctype('text/plain');
			$form->setFormAction('/f/f/f/f/f/f/f');
			$form->setFormAutoComplete('off');
			$form->setFormCharset('cp1251');
			$form->setFormName('asas');
		});
		$new_form->field('img_field')
			->jevix()
			->id('field_name_id')
			->label('field_name_label')
			->placeholder('field_name_placeholder')
			->class('field_name_class')
			->type('field_name_type')
			->title('field_name_title')
			->data('field_name_key','field_name_value')
			->data('id',35)
			->files(function(Multiple $files){
				$files->multiple()
					->accept('image',array('jpg','gif','pngs'))
					->max_size(1045)
					->min_size(3333333333);
			})->check(function(Checkers $validator){
				$validator->required();
				$validator->min(2);
			});
		$new_form->field('imgages')
			->jevix()
			->id('field_name_id')
			->label('field_name_label')
			->placeholder('field_name_placeholder')
			->class('field_name_class')
			->type('field_name_type')
			->title('field_name_title')
			->data('field_name_key','field_name_value')
			->data('id',35)->check(function(Checkers $validator){
				$validator->required();
				$validator->min(2);
			});

		fx_die($new_form->can() ? $new_form->getFieldsList() : array(
			$new_form->getFieldsList(),
			$new_form->getErrors(),
			$new_form->getFormAttributes(),
			fx_encode($user->getCSRFToken()),
		));

	----------------------------------------------------------------------------------------------

		use Core\Classes\Form\Interfaces\Validator;
		use Core\Classes\Form\Interfaces\Checkers;
		use Core\Classes\Form\Form;
		use Core\Classes\Form\Interfaces\Form as FormInterface;
		use Core\Classes\Form\Interfaces\Multiple;
		use Core\Classes\Request;
		use Core\Classes\Form\Interfaces\Params;

		$form = Form::getStaticValidatorInterface(function(Validator $validator){
			$validator->csrf(1)
				->validate(1)
				->setData(Request::getInstance()->getArray('test'));
			$validator->form(function(FormInterface $form){
				$form->setFormName('simple');
				$form->setFormMethod('GET');
				$form->setFormEnctype('text/plain');
			});
			$validator->field('img_field')
				->jevix()
				->params(function(Params $params){
					$params->field_sets('sd');
					$params->show_in_item(false);
					$params->show_in_form(false);
					$params->show_in_filter(false);
					$params->filter('equal');
					$params->filter_position('main');
					$params->item_position('main');
					$params->form_position('main');
				})
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
				->files(function(Multiple $file){
					$file->multiple()
						->accept('image',array('gif','guf','gaf'))
						->min_size(2222222221)
						->max_size(-299);
				})
				->check(function(Checkers $checkers){
					$checkers->required()->int()->email()->numeric()->boolean();
				});
			return $validator;
		});

		fx_die($form->can() ? $form->getFieldsList() : array(
			$form->getFieldsList(),
			$form->getErrors(),
			$form->getFormAttributes(),
		));
	*/

	namespace Core\Classes\Form;

	use Core\Classes\Form\Interfaces\Params;
	use Core\Classes\Jevix;
	use Core\Classes\Config;
	use Core\Classes\Form\Interfaces\Checkers;
	use Core\Classes\Form\Interfaces\Form;
	use Core\Classes\Form\Interfaces\Validator as ValidatorInterface;
	use Core\Classes\Language;
	use Core\Classes\Session;
	use Core\Controllers\Home\Model;

	class Validator implements ValidatorInterface, Checkers, Form, Params{

		const CSRF_TOKEN_EQUAL = 'equal';
		const CSRF_TOKEN_NOT_FOUND = 'not_found';
		const CSRF_TOKEN_NOT_EQUAL = 'not_equal';

		protected $label;

		public $field;
		protected $value;
		protected $check_csrf=true;

		protected $validate_status = false;
		protected $errors = array();
		protected $data = array();
		protected $fields_list = array();

		protected $filter_query;
		protected $filter_data_to_replace = array();

		protected $default_attributes = array(
			'autocomplete' => 'on',
			'placeholder' => null,
			'required' => null,
			'readonly' => null,
			'html_min' => null,
			'html_max' => null,
			'title' => null,
			'class' => 'form-control',
			'name' => null,
			'type' => 'text',			// аттрибут поля 'type'
			'value' =>null,
			'min' => null,
			'max' => null,
			'id' => null,
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
				'filter_validation'	=> '=',	// string [ = | != | > | < | <= | >= ]
				'filter_query'		=> null,	// return "where [field] [filter_validation] [value]";
				'render_type'		=> 'text',	// вывод рендинга в item
				'field_type' 		=> 'simple',// вывод рендинга в form
				'label' 			=> null,
				'description' 		=> null,
				'default_value' 	=> null,
				'wysiwyg' 			=> 'tinymce',
				'variants'	 		=> array(),
			),
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

		protected $config;
		protected $session;

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
			$this->session = Session::getInstance();
			$this->setCSRFAttributes();
		}

		public function files($callable_or_array,$extensions = array()){
			$this->setFormEnctype('multipart/form-data');
			$this->setFormMethod('POST');
			$this->setAttribute('type','file');
			$this->fields_list[$this->field]['attributes'] = array_merge($this->fields_list[$this->field]['attributes'],$this->default_files_attributes);
			$files = new File($this,$extensions);
			if(is_callable($callable_or_array)){
				call_user_func($callable_or_array,$files);
			}
			if(is_array($callable_or_array)){
				foreach($callable_or_array as $method=>$params){
					if(method_exists($files,$method)){
						call_user_func_array(array($files,$method),(is_array($params)?$params:array($params)));
					}
				}
			}

			$files->prepareExtensions($extensions);

			$this->setAttribute('accept',$files->extensions);
			$files->setFiles();
			return $this;
		}

		public function getCurrentField(){
			return $this->field;
		}
		public function getValidatorStatus(){
			return $this->validate_status;
		}

		public function setDefaultFieldsAttributes(array $attributes){
			$this->default_attributes = $attributes;
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

		public function setDataToFieldList($data_key,$attribute_key,$attribute_value){
			$this->fields_list[$this->field][$data_key][$attribute_key] = $attribute_value;
			return $this;
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

		public function value($value=null){
			$this->value = $value;
			if(isset($this->data[$this->field])){
				$this->value = $this->data[$this->field];
			}else{
				$this->value = null;
			}
			return $this->setAttribute(__FUNCTION__,$this->value);
		}

		public function setError($error_data_value,$key=null){
			if(!$key){
				$this->errors[$this->field][] = $this->fields_list[$this->field]['errors'][] = $error_data_value;
				return $this;
			}
			$this->errors[$this->field][$key] = $this->fields_list[$this->field]['errors'][$key] = $error_data_value;
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
		public function field($field){
			$this->field = $field;
			$this->label = null;
			$this->setDefaultAttributes();
			$this->setAttribute('name',$this->field);
			$this->setParams('validate_status',$this->validate_status);
			$this->setParams('original_name',$this->field);
			return $this->value();
		}

		public function autocomplete($default){
			return $this->setAttribute('autocomplete',$default);
		}
		public function class($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function description($default){
			return $this->setParams(__FUNCTION__,$default);
		}
		public function placeholder($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function label($default){
			$this->label = $default;
			return $this->setParams(__FUNCTION__,$default);
		}
		public function title($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function id($default){
			return $this->setAttribute(__FUNCTION__,$default);
		}
		public function type($default){
			if(fx_equal($default,'submit')){ $this->form_attributes['submit'] = true; }
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
			return $this;
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
					'%field%'	=> $this->label
				)
			));
			return $this;
		}

		public function readonly($default=true){
			$this->setAttribute(__FUNCTION__,$default);
			return $this;
		}

		public function min($default=6){
			$this->setAttribute(__FUNCTION__,$default);
			if(!$this->validate_status){ return $this; }
			if(mb_strlen($this->value)>=$default){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_min_length', array(
					'%field%'	=> $this->label,
					'%count%'	=> $default,
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
					'%field%'	=> $this->label,
					'%count%'	=> $default,
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
					'%field%'	=> $this->label,
					'%count%'	=> $default,
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
					'%field%'	=> $this->label,
					'%count%'	=> $default,
				)
			));
			return $this;
		}

		public function mask($default="a-zA-Z0-9"){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match( "([{$default}]+)",$this->value,$result);
			if(isset($result[0]) && fx_equal($result[0],$this->value)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_mask', array(
					'%field%'	=> $this->label,
					'%mask%'	=> $default,
				)
			));
			return $this;
		}

		public function email($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("/^[A-Za-zА-Яа-яЁё0-9\.\-\_]+\@[A-Za-zА-Яа-яЁё0-9\.\-\_]+.[A-Za-zА-Яа-яЁё0-9]$/u",$this->value,$result);
			if(isset($result[0]) && fx_equal($result[0],$this->value)){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_email', array(
					'%field%'	=> $this->label,
				)
			));
			return $this;
		}

		public function phone($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->value = ltrim($this->value,'+');
			$phone = (int)$this->value;
			if($phone == $this->value){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_phone', array(
					'%field%'	=> $this->label,
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
				'%field%'	=> $this->label,
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
				'%field%'	=> $this->label,
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
				'%field%'	=> $this->label,
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
				'%field%'	=> $this->label,
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
				'%field%'	=> $this->label,
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
				'%field%'	=> $this->label,
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
				'%field%'	=> $this->label,
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
				'%field%'	=> $this->label,
			)));
			return $this;
		}

		public function lower_letters($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#[a-z]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_lower_letters',array(
				'%field%'	=> $this->label,
			)));
			return $this;
		}

		public function upper_letters($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#[A-Z]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_upper_letters',array(
				'%field%'	=> $this->label,
			)));
			return $this;
		}

		public function numeric($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#[0-9]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_numeric',array(
				'%field%'	=> $this->label,
			)));
			return $this;
		}

		public function symbols($default="\!\@\#\$%\^&*()_+=-][~`|}{':\";?/.,<>"){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#[{$default}]#",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_symbols',array(
				'%field%'	=> $this->label,
				'%pattern%'	=> stripslashes($default),
			)));
			return $this;
		}

		public function lower_cyrillic($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#([а-яёъэ]+)#u",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_lower_cyrillic',array(
				'%field%'	=> $this->label,
			)));
			return $this;
		}

		public function upper_cyrillic($default=true){
			if(!$this->validate_status){ return $this; }
			if(!$default){ return $this; }
			$this->preg_match("#([А-ЯЁЪЭ]+)#u",$this->value,$search);
			if(!empty($search[0])){
				return $this;
			}
			$this->setError(fx_lang('fields.error_field_not_upper_cyrillic',array(
				'%field%'	=> $this->label,
			)));
			return $this;
		}

		protected function setCSRFAttributes(){
			$this->field($this->config->session['csrf_key_name']);
			$this->setAttribute('type','hidden');
			$this->setAttribute('class',$this->config->session['csrf_key_name']);
			$this->setAttribute('value',fx_csrf());
			$this->setAttribute('required',true);
			$this->setParams('field_sets','csrf');
			$this->setParams('field_type','hidden');
			$this->setParams('field_sets_field_class','m-0 csrf');
			$this->setParams('filter_validation',null);
			return $this;
		}
		protected function checkCSRF(){
			if(!$this->validate_status){ return $this; }
			if(!$this->check_csrf){ return $this; }
			$this->field = $this->config->session['csrf_key_name'];
			$csrf_result_checking = fx_csrf_equal($this->field);
			if(fx_equal($csrf_result_checking,self::CSRF_TOKEN_EQUAL)){
				return $this;
			}
			$this->setError(fx_lang("fields.csrf_token_error_{$csrf_result_checking}"));
			return $this;
		}
		protected function setValidationStatus($status){
			$this->validate_status = $status;
			return $this;
		}
		protected function setDefaultAttributes(){
			$this->fields_list[$this->field]['attributes'] = $this->default_attributes;
			return $this;
		}
		protected function preg_match($pattern,$subject,&$matches,$flags=0,$offset=0){
			if(!is_string($this->value)){
				return $this->setError(fx_lang('fields.error_field_not_string', array(
						'%field%'	=> $this->label,
					)
				),$this->field);
			}
			preg_match($pattern,$subject,$matches,$flags,$offset);
			return $matches;
		}

		public function dont_prepare(){
			return $this;
		}

		public function prepare(callable $callback_function=null){
			if($callback_function && $this->validate_status){
				$this->value = call_user_func($callback_function,$this->value);
				$this->setAttribute('value',$this->value);
			}
			return $this;
		}

		public function jevix($prepare = true){
			if($prepare && $this->validate_status){
				$jevix = new Jevix(array(
					'text'		=> $this->value,
					'is_auto_br'=> false
				));
				$this->value = $jevix->start()
					->result();
				$this->setAttribute('value',$this->value);
			}
			return $this;
		}

		public function htmlentities($quote_style=null,$charset=null,$double_encode=true){
			if(!$this->validate_status){ return $this; }
			$this->value = fx_htmlentities($this->value,$quote_style,$charset,$double_encode);
			$this->setAttribute('value',$this->value);
			return $this;
		}

		public function htmlspecialchars($flags=ENT_COMPAT,$encoding="UTF-8",$double_encode=true){
			if(!$this->validate_status){ return $this; }
			$this->value = fx_htmlspecialchars($this->value,$flags,$encoding,$double_encode);
			$this->setAttribute('value',$this->value);
			return $this;
		}

		public function form($callback_or_array){
			if(is_callable($callback_or_array)){
				call_user_func($callback_or_array,$this);
			}
			if(is_array($callback_or_array)){
				foreach($callback_or_array as $method => $param){
					$callable_method = "setForm{$method}";
					if(method_exists($this,$callable_method)){
						call_user_func(array($this,$callable_method),$param);
					}else{
						call_user_func(array($this,"setForm"),$param);
					}
				}
			}
			return $this;
		}
		public function getFormAttributes(){
			return $this->form_attributes;
		}
		public function setFormCharset($value){
			$this->form_attributes['accept-charset'] = $value;
			return $this;
		}
		public function setFormAction($value){
			$this->form_attributes['action'] = $value;
			return $this;
		}
		public function setFormAutoComplete($value){
			$this->form_attributes['autocomplete'] = $value;
			return $this;
		}
		public function setFormEnctype($value){
			$this->form_attributes['enctype'] = $value;
			return $this;
		}
		public function setFormMethod($value){
			$this->form_attributes['method'] = $value;
			return $this;
		}
		public function setFormName($form_name){
			$this->form_attributes['name'] = $form_name;
			return $this;
		}
		public function setFormValidation($value){
			$this->form_attributes['novalidate'] = $value;
			return $this;
		}
		public function setFormRel($value){
			$this->form_attributes['rel'] = $value;
			return $this;
		}
		public function setFormTarget($value){
			$this->form_attributes['target'] = $value;
			return $this;
		}
		public function setFormClass($value){
			$this->form_attributes['class'] = $value;
			return $this;
		}
		public function setFormId($value){
			$this->form_attributes['id'] = $value;
			return $this;
		}
		public function setFormTitle($value){
			$this->form_attributes['title'] = $value;
			return $this;
		}
		public function setForm($key,$value){
			$this->form_attributes[$key] = $value;
			return $this;
		}

		public function setParams($attribute_key,$attribute_value){
			$this->fields_list[$this->field]['attributes']['params'][$attribute_key] = $attribute_value;
			return $this;
		}

		public function params($callback_or_array){
			if(is_callable($callback_or_array)){
				call_user_func($callback_or_array,$this);
			}
			if(is_array($callback_or_array)){
				foreach($callback_or_array as $callable_method => $param){
					if(method_exists($this,$callable_method)){
						call_user_func(array($this,$callable_method),$param);
					}
				}
			}
			return $this;
		}

		public function show_in_form($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function show_in_item($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function default_value($default){
			if(!$this->validate_status){
				$this->setAttribute('value',$default);
			}
			return $this;
		}
		public function variants(array $value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function show_in_filter($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function field_sets($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function wysiwyg($value='tinymce'){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function form_position($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function item_position($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function filter_validation($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function filter_position($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function field_sets_field_class($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function render_type($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function show_label_in_form($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function show_title_in_form($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function field_type($default){
			return $this->setParams(__FUNCTION__,$default);
		}
		public function show_validation($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}
		public function filter_query($value){
			$this->setParams(__FUNCTION__,$value);
			return $this;
		}

		public function captcha(){
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

		public function setCaptcha(){
			$this->field('captcha');
			$this->setAttribute('required',true);
			$this->setAttribute('autocomplete','off');
			$this->setParams('field_type','captcha');
			$this->setParams('field_sets_field_class','col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12');
			return $this->captcha();
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

		public function getQuery(){
			return $this->filter_query;
		}

		public function getReplacingData(){
			return $this->filter_data_to_replace;
		}







	}














