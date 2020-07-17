<?php

	/*
		$fields_array = array(
			array(
				'name'		=> 'field_name',
				'required'	=> true,
				'type'		=> 'checkbox',
				'id'		=> 'field_name',
				'float'		=> true
			),
			array(
				'name'		=> 'field_name1',
				'required'	=> true,
				'type'		=> 'numeric',
				'id'		=> 'field_name1',
				'numeric'	=> true
			),
			array(
				'name'		=> 'field_name2',
				'required'	=> true,
				'type'		=> 'ip',
				'id'		=> 'field_name2',
			),
			array(
				'name'		=> 'field_name3',
				'required'	=> true,
				'type'		=> 'mac',
				'id'		=> 'field_name3',
			),
		);
		$form = new \Core\Form\Form('form');
		$form->nonCheckCSRF();
		$form->setData($request->get('form'));
		$form->checkCSRF();
		$form->setArrayFields($fields_array);
		$form->checkArrayFields();

		fx_die($form->can() ? 'OK' : $form->getErrors());
	*/

	namespace Core\Form;

	class Form extends Validator{

		private $fields_array;

		public function setArrayFields($fields_array){
			$this->fields_array = $fields_array;
			return $this;
		}

		public function checkArrayFields(){
			foreach($this->fields_array as $field){
				$this->checkField($field);
			}
			return $this;
		}

		public function checkField($field_value){
			$this->field($field_value['name']);
			foreach($field_value as $key=>$value){
				if(method_exists($this,$key)){
					call_user_func_array(array($this,$key),array($value));
				}
			}
			return $this;
		}


















	}














