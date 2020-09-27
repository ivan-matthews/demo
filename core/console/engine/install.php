<?php

	#CMD: engine install [with_demo_data = false, memory_limit = 2048MB]
	#DSC: cli.install_value_description
	#EXM: engine install true 4096MB

	namespace Core\Console\Engine;

	use Core\Classes\Config;
	use Core\Classes\Console\Console;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interfaces\Types as PaintInterface;
	use Core\Classes\Console\Interactive;
	use Core\Console\Config\Set;
	use Core\Console\Migration\Insert;
	use Core\Console\Migration\Run;

	class Install extends Console{

		public $memory_limit;
		public $db_driver = 'mysql';
		public $config;

		public function __construct(){
			$this->config = Config::getInstance();
		}

		public function execute($with_demo_data='false',$memory_limit='512MB'){
			$this->memory_limit = $memory_limit;

			$this->setMemoryLimit();
			$this->renameHtaccessFile();
			$this->renameComposerJsonFile();
			$this->runComposer();
			$this->setConfigs();
			$this->runMigrations();
			if(!fx_equal($with_demo_data,'false')){
				$this->insertMigrations();
			}
			return $this->result;
		}

		public function setMemoryLimit(){
			$this->memory_limit = $this->prepareMemorySuffix($this->memory_limit);
			ini_set('memory_limit',$this->memory_limit);
			return $this;
		}

		public function prepareMemorySuffix($memory){
			$letter = strtolower(substr($memory,-1));
			$mem_size = substr($memory,0,-1);
			switch($letter){
				case fx_equal($letter,'b'):
					return $mem_size;
					break;
				case fx_equal($letter,'k'):
					return $mem_size * 1024;
					break;
				case fx_equal($letter,'m'):
					return $mem_size * 1024 * 1024;
					break;
				case fx_equal($letter,'g'):
					return $mem_size * 1024 * 1024 * 1024;
					break;
				case fx_equal($letter,'t'):
					return $mem_size * 1024 * 1024 * 1024 * 1024;
					break;
				case fx_equal($letter,'p'):
					return $mem_size * 1024 * 1024 * 1024 * 1024 * 1024;
					break;
				default:
					return $mem_size;
			}
		}

		public function renameComposerJsonFile(){
			$composer_json_file = fx_path('composer.json.default');
			$new_composer_json_file = fx_path('composer.json');
			if(file_exists($composer_json_file) && !file_exists($new_composer_json_file)){
				copy($composer_json_file,$new_composer_json_file);
			}
			return $this;
		}

		public function renameHtaccessFile(){
			$htaccess_file = fx_path('.htaccess.default');
			$new_htaccess_file = fx_path('.htaccess');
			if(file_exists($htaccess_file) && !file_exists($new_htaccess_file)){
				copy($htaccess_file,$new_htaccess_file);
			}
			return $this;
		}

		public function runComposer(){
			Paint::exec(function(PaintInterface $paint){
				$paint->string(fx_lang('cli.wait_composer_install'))->fon('blue')->print();
				$paint->eol();
			});
			$result = exec("composer update");
			Paint::exec(function(PaintInterface $paint){
				$paint->string(fx_lang('cli.wait_composer_ready'))->fon('green')->print();
				$paint->eol();
			});
			print $result;
			return $this;
		}

		public function setConfigs(){
			$this->setDataBaseDriver();
			$this->setDataBaseHost();
			$this->setDataBasePort();
			$this->setDataBaseUser();
			$this->setDataBasePassword();
			$this->setDataBaseName();

			$this->setSiteScheme();
			$this->setSiteHost();
			$this->setSiteName();

			return $this;
		}

		public function setDataBaseDriver(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.use_mysql'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.use_mysql_simple'))->get();
					return $string;
				}));
//				$this->db_driver = $interactive->getDialogString();
				$this->updateConfigs($this->db_driver,'core',array(
					'db_driver'
				));
			});
			return $this;
		}

		public function setDataBaseHost(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.enter_db_host'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.enter_db_host_simple'))->get();
					return $string;
				}));
				$this->updateConfigs($interactive->getDialogString(),'database',array(
					$this->db_driver, 'host'
				));
			});
			return $this;
		}
		public function setDataBasePort(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.enter_db_port'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.enter_db_port_simple'))->get();
					return $string;
				}));
				$this->updateConfigs($interactive->getDialogString(),'database',array(
					$this->db_driver, 'port'
				));
			});
			return $this;
		}
		public function setDataBaseUser(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.enter_db_user'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.enter_db_user_simple'))->get();
					return $string;
				}));
				$this->updateConfigs($interactive->getDialogString(),'database',array(
					$this->db_driver, 'user'
				));
			});
			return $this;
		}
		public function setDataBasePassword(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.enter_db_password'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.enter_db_password_simple'))->get();
					return $string;
				}));
				$this->updateConfigs($interactive->getDialogString(),'database',array(
					$this->db_driver, 'pass'
				));
			});
			return $this;
		}
		public function setDataBaseName(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.enter_db_base'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.enter_db_base_simple'))->get();
					return $string;
				}));
				$this->updateConfigs($interactive->getDialogString(),'database',array(
					$this->db_driver, 'base'
				));
			});
			return $this;
		}

		public function setSiteScheme(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.enter_site_scheme'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.enter_site_scheme_simple'))->get();
					return $string;
				}));
				$this->updateConfigs($interactive->getDialogString(),'core',array(
					'site_scheme'
				));
			});
			return $this;
		}
		public function setSiteHost(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.enter_site_host'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.enter_site_host_simple'))->get();
					return $string;
				}));
				$this->updateConfigs($interactive->getDialogString(),'core',array(
					'site_host'
				));
			});
			return $this;
		}
		public function setSiteName(){
			Interactive::exec(function(Interactive $interactive){
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$string = '';
					$string .= $types->string(fx_lang('cli.enter_site_name'))->fon('yellow')->get();
					$string .= $types->string(fx_lang('cli.enter_site_name_simple'))->get();
					return $string;
				}));
				$this->updateConfigs($interactive->getDialogString(),'core',array(
					'site_name'
				));
			});
			return $this;
		}

		public function updateConfigs($value, $file, array $params){
			$config_updater_object = new Set();
			$config_updater_object->execute($value,$file,...$params);
			$this->config->set($value, $file, ...$params);
			return $this;
		}

		public function runMigrations(){
			$migration_runner_object = new Run();
			$migration_runner_object->execute();
			return $this;
		}

		public function insertMigrations(){
			$migration_runner_object = new Insert();
			$migration_runner_object->execute();
			return $this;
		}












	}
