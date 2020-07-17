<?php

	#CMD: php cli help
	#DSC: call help center
	#EXM: php cli help

	namespace System\Console\Help;

	use Core\Classes\Console;
	use Core\Classes\Paint;

	class Index{

		protected $EOL = PHP_EOL;
		protected $files_dir;
		protected $help_info = array();

		public function execute(){
			$this->files_dir = fx_path('system/console');
			$this->getFiles();

			Paint::exec(function(Paint $print){
				$print->string(str_repeat('-',100))->toPaint()->eol();
				$print->tab()->tab()->tab()->tab()->string('CLI commands aliases:')->fon('green')
					->toPaint()->eol();
				$print->string(str_repeat('-',100))->toPaint()->eol();
			});

			$this->getAliasesCommandsInfo();

			return true;
		}

		protected function getFiles(){
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

		protected function searchHelpInfo($file_data){
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

		protected function printDirectoryName($directory){
			Paint::exec(function(Paint $paint)use($directory){
				$paint->tab()->string($directory)->color('white')->fon('red')->toPaint();
				$paint->eol();
			});
			return $this;
		}

		protected function printHelpInfo($command,$description,$example){
			$command = trim($command);
			$description = trim($description);
			$example = trim($example);

			Paint::exec(function(Paint $paint)use($command,$description,$example){
				$paint->tab()->tab();
				$paint->string($command)->color('yellow')->toPaint();
				$paint->string(' - ')->toPaint();
				$paint->string(mb_strtoupper($description))->color('cyan')->toPaint();
				$paint->string(' (')->toPaint();
				$paint->string($example)->color('red')->toPaint();
				$paint->string(')')->toPaint();
				$paint->eol();
			});
			return true;
		}

		protected function getAliasesCommandsInfo(){
			$console = Console::getInstance();
			foreach($console->aliases_file_data as $value){
				$this->printHelpInfo(
					"php cli {$value['command']}",
					$value['description'],
					"php cli {$value['example']}"
				);
			}
			return $this;
		}



















	}