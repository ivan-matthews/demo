<?php

	#CMD: config set [config_value, config_file, ...array_multilevel_keys]
	#DSC: cli.default_description_string
	#EXM: config set InnoDB database mysql engine

	namespace Core\Console\Config;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;

	class Set extends Console{

		public $cfg_dir_path = 'system/config';

		public $config_file;
		public $config_value;
		public $array_multilevel_keys;

		public $config_file_path;
		public $config_file_data;

		public function execute($config_value, $config_file, ...$array_multilevel_keys){
			$this->config_file				= $config_file;
			$this->config_value				= $config_value;
			$this->array_multilevel_keys	= $array_multilevel_keys;

			$this->setFilePath($this->config_file);
			$this->getFileData($this->config_file_path);
			$this->updateConfig();
			$this->saveConfigFile();

			return $this->result;
		}

		public function setFilePath($file){
			$this->config_file_path = fx_path("{$this->cfg_dir_path}/{$file}.php");
			return $this;
		}

		public function getFileData($path_to_file){
			$this->config_file_data = include $path_to_file;
			return $this;
		}

		public function updateConfig(){
			fx_set_multilevel_array($this->config_file_data,$this->config_value,...$this->array_multilevel_keys);
			return $this;
		}

		public function saveConfigFile(){
			$this->config_file_data = fx_php_encode($this->config_file_data);
			file_put_contents($this->config_file_path,$this->config_file_data);
			return $this;
		}
















	}