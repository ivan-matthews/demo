<?php

	#CMD: make cmd [cmd_folder], [cmd_file], [...cmd_arguments]
	#DSC: cli.new_cli_command_class_file
	#EXM: make cmd server run host port

	namespace Core\Console\Make;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;

	class Cmd extends Console{

		public $console_folder;
		public $console_command;

		public $command_directory;
		public $command_namespace;
		public $command_file;
		public $command_class;
		public $command_arguments;
		public $command_file_template;
		public $command_file_template_data;
		public $command_file_template_prepared_data;

		public function execute($command_directory,$command_file='index',...$command_arguments){
			$this->console_folder = fx_path("core/console");

			$this->command_directory = strtolower($command_directory);
			$this->command_namespace = $this->prepareClassName($command_directory);
			$this->command_file = strtolower($command_file);
			$this->command_class = $this->prepareClassName($command_file);
			$this->command_arguments = $command_arguments;
			$this->command_file_template = fx_php_path("system/console/commandClass.tmp");

			$this->getTmpFileData();
			$this->prepareFileData();
			$this->getConsoleCommandString();
			$this->saveDataToFile();

			return $this->result;
		}

		public function getTmpFileData(){
			$this->command_file_template_data = file_get_contents($this->command_file_template);
			return $this;
		}

		public function saveDataToFile(){
			$file_new_dir = "{$this->console_folder}/{$this->command_directory}";
			$file_new_path = "{$file_new_dir}/{$this->command_file}.php";
			fx_make_dir($file_new_dir);
			$this->result = $file_new_path;
			if(!file_exists($file_new_path)){
				file_put_contents($file_new_path,$this->command_file_template_prepared_data);
				$this->success($file_new_path,$this->console_command);
				return true;
			}
			$this->skipped($file_new_path,$this->console_command);
			return true;
		}

		public function getConsoleCommandString(){
			$this->console_command = $this->command_directory;
			$this->console_command .= (fx_equal($this->command_file,'index')?null:" {$this->command_file} ");
			$this->console_command .= implode(' ',$this->command_arguments);
			$this->console_command = trim($this->console_command);
			return $this;
		}

		public function prepareFileData(){
			$class_properties =
			$class_input_params =
			$declared_class_properties =
				$this->command_arguments;

			$class_properties = fx_array_callback($class_properties,function(&$key,&$value){
				$value = "\t\t" . 'public $' . $value . ';' . PHP_EOL;
			});
			$class_input_params = fx_array_callback($class_input_params,function(&$key,&$value){
				$value = '$' . $value;
			});
			$declared_class_properties = fx_array_callback($declared_class_properties,function(&$key,&$value){
				$value = "\t\t\t" . '$this->' . $value . '	= $' . $value . ';' . PHP_EOL;
			});

			$this->command_file_template_prepared_data = str_replace(
				array(
					'__command_directory__',
					'__command_file_description__',
					'__command_arguments_with_comma_separated__',
					'__command_arguments__',
					'__command_namespace__',
					'__command_class__',
					'/*class properties*/',
					'/*class input params*/',
					'/*declared class properties*/',
				),
				array(
					$this->command_directory,
					(fx_equal($this->command_file,'index')?null:" {$this->command_file}"),
					($this->command_arguments ? '[' . implode(', ',$this->command_arguments) . ']' : null),
					implode(' ',$this->command_arguments),
					$this->command_namespace,
					$this->command_class,
					implode('',$class_properties),
					implode(', ',$class_input_params),
					implode('',$declared_class_properties),
				),
				$this->command_file_template_data);
			return $this;
		}

		public function success($command_file,$console_command){
			return Paint::exec(function(Types $print)use($command_file,$console_command){
				$print->string(fx_lang('cli.success_header'))->color('green')->print()->space();
				$print->string(fx_lang('cli.command_success_save',array(
					'%CMD_NAME%'	=> $print->string($console_command)->fon('green')->get(),
					'%CMD_FILE%'	=> $print->string($command_file)->color('green')->get(),
				)))->print()->eol();
			});
		}

		public function skipped($command_file,$console_command){
			return Paint::exec(function(Types $print)use($command_file,$console_command){
				$print->string(fx_lang('cli.error_header'))->color('red')->print()->space();
				$print->string(fx_lang('cli.command_not_save',array(
					'%CMD_NAME%'	=> $print->string($console_command)->fon('red')->get(),
					'%CMD_FILE%'	=> $print->string($command_file)->color('red')->get(),
				)))->print()->eol();
			});
		}

















	}