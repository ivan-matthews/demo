<?php

	#CMD: help
	#DSC: call help center
	#EXM: help

	namespace System\Console\Help;

	use Core\Console\Console;
	use Core\Console\Paint;

	class Index extends Console{

		private $structured;

		private $EOL = PHP_EOL;
		private $files_dir;
		private $separator_string;
		private $aliases_section = null;

		public function execute($structured=null){
			$this->separator_string = str_repeat('-',100);
			$this->structured = $structured;
			$this->files_dir = fx_path('system/console');

			$this->getAliasesCommandsInfo();
			$this->getFiles();

			return $this->result;
		}

		private function getFiles(){
			Paint::exec(function(Paint $print){
				$print->string($this->separator_string)->toPaint()->eol();
				$print->string('CLI commands native:')->fon('blue')
					->toPaint()->eol();
				$print->string($this->separator_string)->toPaint()->eol();
			});
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
			print PHP_EOL;
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
			Paint::exec(function(Paint $print)use($directory){
				$print->string($directory)->color('white')->fon('red')->toPaint();
				$print->eol();
			});
			return $this;
		}

		private function prepareCommandParams(Paint $print, $params_string, $finder_element=','){
			$params_string = str_replace(array('[',']'),array('',''),$params_string);
			if(strpos($params_string,$finder_element) !== false){
				$params_array = explode($finder_element,$params_string);
				$printing_string = '';
				foreach($params_array as $item){
					$printing_string .= $print->string('[')->get();
					$printing_string .= $print->string($item)->color('yellow')->get();
					$printing_string .= $print->string('], ')->get();
				}
				print rtrim($printing_string,", \e[0m");
			}else{
				$print->string('[')->toPaint();
				$print->string($params_string)->color('yellow')->toPaint();
				$print->string(']')->toPaint();
			}
			return $this;
		}

		private function printHelpInfo($command,$description,$example){
			$command = trim($command);
			$description = trim($description);
			$example = trim($example);
			Paint::exec(function(Paint $print)use($command,$description,$example){
				$print->tab();
				$print->string("php ")->color('brown')->toPaint();
				$print->string("cli ")->color('green')->toPaint();
				$search_params = strpos($command,'[');
				$params_string = null;
				if($search_params){
					$params_string = substr($command,$search_params);
					$command = substr($command,0,$search_params);
				}
				$print->string($command)->color('light_green')->toPaint();
				if($params_string){
					$this->prepareCommandParams($print,$params_string);
				}
				$print->string(' - ')->toPaint();
				$print->string("{$description} ")->color('light_cyan')->toPaint();
				if($this->structured){ $print->eol()->tab(); }
				$print->string("php ")->color('brown')->toPaint();
				$print->string("cli ")->color('green')->toPaint();
				$print->string($example)->color('light_green')->toPaint();
				$print->eol();
				if($this->structured){ $print->eol(); }
			});
			return true;
		}

		private function getAliasesCommandsInfo(){
			Paint::exec(function(Paint $print){
				$print->string($this->separator_string)->toPaint()->eol();
				$print->string('CLI commands aliases:')->fon('green')
					->toPaint()->eol();
				$print->string($this->separator_string)->toPaint()->eol();
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