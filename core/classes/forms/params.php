<?php

	namespace Core\Classes\Forms;

	trait Params{

		public function param_show_in_form($value){
			$this->fields_list[$this->field]['params']['show_in_form'] = $value;
			return $this;
		}
		public function param_show_in_item($value){
			$this->fields_list[$this->field]['params']['show_in_item'] = $value;
			return $this;
		}
		public function param_show_in_filter($value){
			$this->fields_list[$this->field]['params']['show_in_filter'] = $value;
			return $this;
		}
		public function param_show_label_in_form($value){
			$this->fields_list[$this->field]['params']['show_label_in_form'] = $value;
			return $this;
		}
		public function param_show_title_in_form($value){
			$this->fields_list[$this->field]['params']['show_title_in_form'] = $value;
			return $this;
		}
		public function param_show_validation($value){
			$this->fields_list[$this->field]['params']['show_validation'] = $value;
			return $this;
		}
		public function param_field_sets($value){
			$this->fields_list[$this->field]['params']['field_sets'] = $value;
			return $this;
		}
		public function param_field_sets_field_class($value){
			$this->fields_list[$this->field]['params']['field_sets_field_class'] = $value;
			return $this;
		}
		public function param_form_position($value){
			$this->fields_list[$this->field]['params']['form_position'] = $value;
			return $this;
		}
		public function param_filter_position($value){
			$this->fields_list[$this->field]['params']['filter_position'] = $value;
			return $this;
		}
		public function param_item_position($value){
			$this->fields_list[$this->field]['params']['item_position'] = $value;
			return $this;
		}
		public function param_render_type($value){
			$this->fields_list[$this->field]['params']['render_type'] = $value;
			return $this;
		}
		public function param_field_type($value){
			$this->fields_list[$this->field]['params']['field_type'] = $value;
			return $this;
		}
		public function param_label($value){
			$this->field_name = $value;
			$this->fields_list[$this->field]['params']['label'] = $value;
			return $this;
		}
		public function param_description($value){
			$this->fields_list[$this->field]['params']['description'] = $value;
			return $this;
		}



















	}














