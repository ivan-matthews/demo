<?php

	#CMD: help
	#DSC: cli.un_structure_info
	#EXM: help

	namespace Core\Console\Help;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;

	class Index extends Console{

		private $structured;
		private $script_name;

		private $EOL = PHP_EOL;
		private $files_dir;
		private $separator_string;
		private $aliases_section = null;

		public function execute($structured=null){
			$this->script_name = $this->getFileScriptName();

			$this->separator_string = str_repeat('-',100);
			$this->structured = $structured;
			$this->files_dir = fx_path('core/console');

			$this->getAliasesCommandsInfo();
			$this->getFiles();

			return $this->result;
		}

		private function getFiles(){
			Paint::exec(function(Types $print){
				$print->string($this->separator_string)->print()->eol();
				$print->string(fx_lang('cli.native_cmds_header'))->fon('blue')->print()->eol();
				$print->string($this->separator_string)->print()->eol();
				foreach(scandir($this->files_dir) as $dir){
					if($dir=='.' || $dir=='..'){ continue; }
					$this->printDirectoryName($dir);
					if(is_dir("{$this->files_dir}/{$dir}")){
						foreach(scandir("{$this->files_dir}/{$dir}") as $file){
							if($file=='.' || $file=='..' || is_dir("{$this->files_dir}/{$dir}/{$file}")){ continue; }
							$this->searchHelpInfo(file_get_contents("{$this->files_dir}/{$dir}/{$file}"));
						}
					}
				}
				$print->eol();
			});
			return $this;
		}

		private function searchHelpInfo($file_data){
			preg_match_all(
				"#\#CMD:(.*?){$this->EOL}|\#DSC:(.*?){$this->EOL}|\#EXM:(.*?){$this->EOL}#",
				$file_data,
				$result
			);
			if(!empty($result[1]) && !empty($result[2]) && !empty($result[3])){
				if(isset($result[1][0]) && isset($result[2][1]) && isset($result[3][2])){
					return $this->printHelpInfo($result[1][0],$result[2][1],$result[3][2]);
				}
			}
			return false;
		}

		private function printDirectoryName($directory){
			Paint::exec(function(Types $print)use($directory){
				$print->string($directory)->color('white')->fon('red')->print();
				$print->eol();
			});
			return $this;
		}

		private function prepareCommandParams(Types $print, $params_string){
			$result_string = preg_replace_callback("/\[(.*?)\]/",function($find)use($print){
				$str = $print->string('[')->get();
				$str .= $print->string($find[1])->color('yellow')->get();
				$str .= $print->string(']')->get();
				return $str;
			},$params_string);
			$print->string($result_string)->print();
			return $this;
		}

		private function printHelpInfo($command,$description,$example){
			$command = trim($command);
			$description = trim($description);
			$description = fx_lang($description);
			$example = trim($example);
			Paint::exec(function(Types $print)use($command,$description,$example){
				$print->tab();
				$print->string("php ")->color('brown')->print();
				$print->string("{$this->script_name} ")->color('green')->print();
				$search_params = strpos($command,'[');
				$params_string = null;
				if($search_params){
					$params_string = substr($command,$search_params);
					$command = substr($command,0,$search_params);
				}
				$print->string($command)->color('light_green')->print();
				if($params_string){
					$this->prepareCommandParams($print,$params_string);
				}
				$print->string(' - ')->print();
				$print->string("{$description} ")->color('light_cyan')->print();
				if($this->structured){ $print->eol()->tab(); }
				$print->string("php ")->color('brown')->print();
				$print->string("{$this->script_name} ")->color('green')->print();
				$print->string($example)->color('light_green')->print()->eol();
				if($this->structured){ $print->eol(); }
			});
			return true;
		}

		private function getAliasesCommandsInfo(){
			Paint::exec(function(Types $print){
				$print->string($this->separator_string)->print()->eol();
				$print->string(fx_lang('cli.alias_cmds_header'))->fon('green')->print()->eol();
				$print->string($this->separator_string)->print()->eol();
			});
			$console = Console::getInstance();
			foreach($console->aliases_file_data as $value){
				if(!fx_equal($value['section'],$this->aliases_section)){
					$this->aliases_section = $value['section'];
					$this->printDirectoryName($value['section']);
				}
				$this->printHelpInfo($value['command'],$value['description'],$value['example']);
			}
			return $this;
		}



















	}