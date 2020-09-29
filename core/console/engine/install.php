<?php

	#CMD: engine install [with_demo_data = false, with_demo_server = true, memory_limit = 1536MB]
	#DSC: cli.install_value_description
	#EXM: engine install true 4096MB

	namespace Core\Console\Engine;

	use Core\Classes\Config;
	use Core\Classes\Console\Console;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interfaces\Types as PaintInterface;
	use Core\Classes\Console\Interactive;
	use Core\Console\Config\Set;
	use Core\Console\Migration\Drop_DB;
	use Core\Console\Migration\Insert;
	use Core\Console\Migration\Run;
	use Core\Console\Server\Run as Server;

	class Install extends Console{

		public $with_demo_data;
		public $with_demo_server;
		public $memory_limit;
		public $db_driver = 'mysql';
		public $config;
		public $config_to_update = array(
			'core'		=> array(
				'db_driver'		=> 'mysql',
				'site_scheme'	=> 'http',
				'site_host'		=> '',
				'site_name'		=> '',
			),
			'database'	=> array(
				'host'	=> 'localhost',
				'port'	=> '3306',
				'user'	=> 'root',
				'pass'	=> '',
				'base'	=> 'simple_database',
			),
		);

		public function __construct(){
			parent::__construct();
			$this->config = Config::getInstance();
		}

		public function execute($with_demo_data='false',$with_demo_server='true',$memory_limit='1536MB'){
			$this->with_demo_data	= $with_demo_data;
			$this->with_demo_server = $with_demo_server;
			$this->memory_limit = $memory_limit;

			$this->printWarningMessage();

			$this->setMemoryLimit();
			$this->renameHtaccessFile();
			$this->renameComposerJsonFile();

			$this->hooks->run('cli_composer_update_before');
			$this->runComposer();
			$this->hooks->run('cli_composer_update_after');

			$this->setConfigs();

			$this->setSecureWord();
			$this->setCryptionKey();

			$this->dropDataBaseIfExists();

			$this->runMigrations();
			if(!fx_equal($this->with_demo_data,'false')){
				$this->insertMigrations();
			}

			$this->installationSuccessFul();

			if(fx_equal($this->with_demo_server,'true')){
				$this->runDemoServer();
			}

			return $this->result;
		}

		public function installationSuccessFul(){
			Paint::exec(function(PaintInterface $types){
				$types->string(fx_lang('cli.installation_finish'))->fon('green')->print();
				$types->eol();
			});
			return $this;
		}

		public function runDemoServer(){
			$server = new Server();
			$server->execute();
			return $this;
		}

		public function printWarningMessage(){
			Interactive::exec(function(Interactive $interactive){
				Paint::exec(function(PaintInterface $types){
					$types->string(fx_lang('cli.engine_install_warning_msg'))->fon('yellow')->print()->eol(2);
					$types->string(fx_lang('cli.engine_install_warning_descr'))->fon('cyan')->print()->eol();
					$types->string(fx_lang('cli.engine_install_warning_descr_msg'))->color('light_green')->print()->space();
					$types->string(fx_lang('cli.engine_install_warning_close'))->fon('red')->print()->eol();
					$types->string(fx_lang('cli.engine_install_warning_descr_msg_list'))->color('light_cyan')->print()->eol();
				});
				$interactive->create(Paint::exec(function(PaintInterface $types){
					$types->string(fx_lang('cli.engine_install_continue'))->fon('green')->print()->eol();
					$types->string(fx_lang('cli.engine_install_warning_close'))->fon('red')->print()->eol();
				}));
			});
			return $this;
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
			Paint::exec(function(PaintInterface $types)use($composer_json_file,$new_composer_json_file){
				$types->string(fx_lang('cli.file_renamed_to_file',array(
					'%file%'	=> Paint::exec(function(PaintInterface $types)use($composer_json_file){
						return $types->string($composer_json_file)->fon('green')->color('white')->get();
					}),
					'%new_file%'	=> Paint::exec(function(PaintInterface $types)use($new_composer_json_file){
						return $types->string($new_composer_json_file)->fon('green')->color('white')->get();
					}),
				)))->color('light_red')->print();
				$types->eol();
			});
			return $this;
		}

		public function renameHtaccessFile(){
			$htaccess_file = fx_path('.htaccess.default');
			$new_htaccess_file = fx_path('.htaccess');
			if(file_exists($htaccess_file) && !file_exists($new_htaccess_file)){
				copy($htaccess_file,$new_htaccess_file);
			}
			Paint::exec(function(PaintInterface $types)use($htaccess_file,$new_htaccess_file){
				$types->string(fx_lang('cli.file_renamed_to_file',array(
					'%file%'	=> Paint::exec(function(PaintInterface $types)use($htaccess_file){
						return $types->string($htaccess_file)->fon('green')->color('white')->get();
					}),
					'%new_file%'	=> Paint::exec(function(PaintInterface $types)use($new_htaccess_file){
						return $types->string($new_htaccess_file)->fon('green')->color('white')->get();
					}),
				)))->color('light_red')->print();
				$types->eol();
			});
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

			$this->checkConfig();

			return $this;
		}

		public function checkConfig(){
			Interactive::exec(function(Interactive $interactive){
				Paint::exec(function(PaintInterface $types){
					$types->string(fx_lang("cli.new_config_is"))->fon('green')->print();
					$types->eol();
				});
				foreach($this->config_to_update as $key=>$item){
					Paint::exec(function(PaintInterface $types)use($key,$item){
						$types->tab();
						$types->string(fx_lang("cli.new_config_parent_{$key}"))->color('light_cyan')->print();
						$types->eol();
					});
					foreach($item as $item_key=>$item_value){
						Paint::exec(function(PaintInterface $types)use($item_key,$item_value){
							$types->tab(2);
							$types->string(fx_lang("cli.new_config_{$item_key}"))->fon('cyan')->print();
							$types->string(" {$item_value}")->print();
							$types->eol();
						});
					}
				}

				$interactive->create(Paint::exec(function(PaintInterface $types){
					return $types->string(fx_lang("cli.new_config_agree"))->fon('green')->get();
				}));

				if(fx_equal(mb_strtolower($interactive->getDialogString()),'y')){
					$this->updateConfigFromArray();
				}else{
					$this->setConfigs();
				}
			});
			return $this;
		}

		public function dropDataBaseIfExists(){
			$drop_object = new Drop_DB();
			$drop_object->execute($this->config_to_update['database']['base']);
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
				$this->setConfig($this->db_driver,'core',array(
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
				$this->setConfig($interactive->getDialogString(),'database',array(
					'host'
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
				$this->setConfig($interactive->getDialogString(),'database',array(
					'port'
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
				$this->setConfig($interactive->getDialogString(),'database',array(
					'user'
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
				$this->setConfig($interactive->getDialogString(),'database',array(
					'pass'
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
				$this->setConfig($interactive->getDialogString(),'database',array(
					'base'
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
				$this->setConfig($interactive->getDialogString(),'core',array(
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
				$this->setConfig($interactive->getDialogString(),'core',array(
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
				$this->setConfig($interactive->getDialogString(),'core',array(
					'site_name'
				));
			});
			return $this;
		}

		public function updateConfigFromArray(){
			foreach($this->config_to_update as $key=>$item){
				foreach($item as $item_key=>$item_value){
					if(fx_equal($key,'database')){
						$this->updateConfigs($item_value,$key,array($this->db_driver,$item_key));
					}else{
						$this->updateConfigs($item_value,$key,array($item_key));
					}
				}
			}
			return $this;
		}

		public function updateConfigs($value, $file, array $params){
			$config_updater_object = new Set();
			$config_updater_object->execute($value,$file,...$params);
			$this->config->set($value, $file, ...$params);
			return $this;
		}

		public function setConfig($value, $file, array $params){
			fx_set_multilevel_array($this->config_to_update, $value, $file, ...$params);
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

		public function setSecureWord(){
			$new_secure_key = fx_gen(128);
			$this->updateConfigs($new_secure_key, 'secure', array('secret_word'));
			return $this;
		}

		public function setCryptionKey(){
			$new_secure_key = fx_gen(128);
			$this->updateConfigs($new_secure_key, 'secure', array('cryption','cryption_key'));
			return $this;
		}












	}
