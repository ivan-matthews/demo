<?php

	namespace Core\Classes\Form;

	use Core\Classes\Kernel;
	use Core\Classes\Form\Interfaces\Multiple;

	class File implements Multiple{

		/** @var array $files prepared files array field_name => array([0]	=> array([name]=> name), [type]...), [1]... */
		private $files;
		private $multiple;
		private $raw_files;
		private $validator;
		private $current_field;
		private $checker_status;
		private $mime_types;
		private $file_default_attributes = array(
			'name'		=> null,
			'type'		=> '/',
			'tmp_name'	=> null,
			'error'		=> null,
			'size'		=> 0,
			'path'		=> null,
		);
		private $errors = array();
		public $extensions;
		public $explicit_extensions;

		public function __construct(Validator $validator,$explicit_extensions = array()){
			$this->raw_files = $_FILES;
			$this->validator = $validator;
			$this->explicit_extensions = $explicit_extensions;
			$this->mime_types = fx_import_file(fx_path('system/assets/mime_types.php'),Kernel::IMPORT_INCLUDE);
			$this->current_field = $this->validator->getCurrentField();
			$this->checker_status = $this->validator->getValidatorStatus();
			$this->getPreparedFiles();
		}

		public function prepareExtensions(array $extensions){
			foreach($extensions as $extension){
				$this->extensions .= ".{$extension},";
			}
			return $this;
		}

		private function acceptSingle($file_type,$subtypes){
			$file_mime_type_array = explode('/',$this->files['type']);
			if(fx_equal($file_type,$file_mime_type_array[0])){
				if(in_array($file_mime_type_array[1],$subtypes)){
					return $this;
				}
			}
			$this->setError($this->current_field,fx_lang('fields.file_mime_type_not_allowed',array(
				'%types%'	=> strtoupper(implode(',',$subtypes)),
				'%type%'	=> strtoupper($file_mime_type_array[1])
			)));
			return $this;
		}

		private function minSizeSingle($default_size){
			if($this->files['size'] >= $default_size){
				return $this;
			}
			return $this->setError($this->current_field,fx_lang('fields.file_min_size_shortage',array(
				'%size%'	=> fx_prepare_memory($default_size),
			)));
		}

		private function maxSizeSingle($default_size){
			if($this->files['size'] <= $default_size){
				return $this;
			}
			$this->setError($this->current_field,fx_lang('fields.file_max_size_exceeded',array(
				'%size%'	=> fx_prepare_memory($default_size),
			)));
			return $this;
		}

		private function acceptMultiple($file_type,$subtypes){
			foreach($this->files as $item){
				$file_mime_type_array = explode('/',$item['type']);
				if(!fx_equal($file_type,$file_mime_type_array[0]) || !in_array($file_mime_type_array[1],$subtypes)){
					$this->setError($this->current_field,fx_lang('fields.file_mime_type_not_allowed',array(
						'%types%'	=> (implode(', ',$subtypes)),
						'%type%'	=> ($file_mime_type_array[1])
					)));
				}
			}
			return $this;
		}

		private function minSizeMultiple($default_size){
			$error = false;
			foreach($this->files as $item){
				if($item['size'] < $default_size){
					$error = true;
				}
			}
			if($error){
				$this->setError($this->current_field,fx_lang('fields.file_min_size_shortage',array(
					'%size%'	=> fx_prepare_memory($default_size),
				)));
			}
			return $this;
		}

		private function maxSizeMultiple($default_size){
			$error = false;
			foreach($this->files as $item){
				if($item['size'] > $default_size){
					$error = true;
				}
			}
			if($error){
				$this->setError($this->current_field,fx_lang('fields.file_max_size_exceeded',array(
					'%size%'	=> fx_prepare_memory($default_size),
				)));
			}
			return $this;
		}

		public function getPreparedFiles(){
			if(!$this->checker_status){ return $this; }

			if(!isset($this->raw_files[$this->current_field])){
				return $this->setError($this->current_field,fx_lang('fields.empty_files_list'));
			}
			foreach($this->raw_files[$this->current_field] as $index=>$value){
				if(is_array($this->raw_files[$this->current_field]['name'])){
					foreach($value as $iterator=>$item){
						if(fx_equal($index,'error')){
							$this->checkError($this->current_field,$item);
						}
						$this->files[$iterator][$index] =
							$item ? $item : $this->file_default_attributes[$index];
					}
				}else{
					if(fx_equal($index,'error')){
						$this->checkError($this->current_field,$value);
					}
					$this->files[$index] =
						$value ? $value : $this->file_default_attributes[$index];
				}
			}
			return $this->setFilesErrors();
		}

		private function setAttribute($attribute_key,$attribute_value){
			$this->validator->setAttribute($attribute_key,$attribute_value);
			$this->validator->setDataToFieldList('file',$attribute_key,$attribute_value);
			return $this;
		}

		private function setError($key,$value){
			$this->errors[$key] = $value;
			$this->validator->setError($value);
			return $this;
		}

		private function checkError($key,$error){
			if($error){
				$this->errors[$key] = fx_lang("fields.file_upload_error_{$error}");
			}
			return $this;
		}

		private function setFilesErrors(){
			if($this->errors){
				$this->validator->setError(fx_lang('fields.file_someone_error_detected',array(
					'%error%' => implode(', ',$this->errors)
				)));
			}
			return $this;
		}

		public function setFiles(){
			$this->validator->setAttribute('files',$this->files);
			return $this;
		}

		public function multiple(){
			$this->multiple = true;
			$this->setAttribute(__FUNCTION__,true);
			$this->validator->setAttribute('name',"{$this->current_field}[]");

			if(!$this->checker_status){ return $this; }
			if($this->errors){ return $this; }
			if(isset($this->files[0])){ return $this; }

			$this->setError($this->current_field,fx_lang('fields.field_type_is_multiple'));
			return $this;
		}

		public function single(){
			$this->multiple = false;

			if(!$this->checker_status){ return $this; }
			if($this->errors){ return $this; }

			if(isset($this->files['name'])){ return $this; }

			$this->setError($this->current_field,fx_lang('fields.field_type_is_not_multiple'));
			return $this;
		}

		public function accept($file_type,$subtypes=array()){
			if(!$subtypes){ $subtypes = isset($this->mime_types[$file_type]) ? $this->mime_types[$file_type] : array(); }

			if(!$this->explicit_extensions){
				$this->extensions = "{$file_type}/*";
			}

			if(!$this->checker_status){ return $this; }
			if($this->errors){ return $this; }
			if($this->multiple){ return $this->acceptMultiple($file_type,$subtypes); }

			return $this->acceptSingle($file_type,$subtypes);
		}

		public function min_size($default_size){
			$this->setAttribute(__FUNCTION__,$default_size);

			if(!$this->checker_status){ return $this; }
			if($this->errors){ return $this; }
			if($this->multiple){ return $this->minSizeMultiple($default_size); }

			return $this->minSizeSingle($default_size);
		}

		public function max_size($default_size){
			$this->setAttribute(__FUNCTION__,$default_size);

			if(!$this->checker_status){ return $this; }
			if($this->errors){ return $this; }
			if($this->multiple){ return $this->maxSizeMultiple($default_size); }

			return $this->maxSizeSingle($default_size);
		}
























	}














