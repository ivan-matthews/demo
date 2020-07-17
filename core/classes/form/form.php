<?php

	/*
		use Core\Classes\Form\Form;

		$fields_array = array(
			array(
				'name'		=> 'field_name',
				'type'		=> 'checkbox',
				'field_type'=> 'checkbox',
				'id'		=> 'field_name',
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
				'attr'		=> 'simple'
			),
			array(
				'name'		=> 'field_name1',
				'type'		=> 'numeric',
				'field_type'=> 'text',
				'id'		=> 'field_name1',
				'required'	=> true,
				'numeric'	=> true
			),
			array(
				'name'		=> 'field_name2',
				'type'		=> 'ip',
				'field_type'=> 'text',
				'id'		=> 'field_name2',
				'required'	=> true,
			),
			array(
				'name'		=> 'field_name3',
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
			fx_encode($user->getCSRFToken())
		));
	*/

	namespace Core\Classes\Form;

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


















	}













