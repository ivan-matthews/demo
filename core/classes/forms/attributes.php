<?php

	namespace Core\Classes\Forms;

	trait Attributes{

		public function field_autocomplete($value){
			$this->fields_list[$this->field]['attributes']['autocomplete'] = $value;
			return $this;
		}
		public function field_placeholder($value){
			$this->fields_list[$this->field]['attributes']['placeholder'] = $value;
			return $this;
		}
		public function field_required($value){
			$this->fields_list[$this->field]['attributes']['required'] = $value;
			return $this;
		}
		public function field_readonly($value){
			$this->fields_list[$this->field]['attributes']['readonly'] = $value;
			return $this;
		}
		public function field_title($value){
			$this->fields_list[$this->field]['attributes']['title'] = $value;
			return $this;
		}
		public function field_class($value){
			$this->fields_list[$this->field]['attributes']['class'] = $value;
			return $this;
		}
		public function field_name($value){
			$this->fields_list[$this->field]['attributes']['name'] = $value;
			return $this;
		}
		public function field_type($value){
			$this->fields_list[$this->field]['attributes']['type'] = $value;
			return $this;
		}
		public function field_value($value=''){
			$this->value = isset($this->data[$this->field]) ? $this->data[$this->field] : $value;
			$this->fields_list[$this->field]['attributes']['value'] = $this->value;
			return $this;
		}
		public function field_min($value){
			$this->fields_list[$this->field]['attributes']['min'] = $value;
			return $this;
		}
		public function field_max($value){
			$this->fields_list[$this->field]['attributes']['max'] = $value;
			return $this;
		}
		public function field_id($value){
			$this->fields_list[$this->field]['attributes']['id'] = $value;
			return $this;
		}



















	}














