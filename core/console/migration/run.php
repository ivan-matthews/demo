<?php

	#CMD: migration run
	#DSC: cli.run_migrations
	#EXM: migration run

	namespace Core\Console\Migration;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Database\Database;
	use Core\Classes\Config;
	use Core\Classes\Kernel;

	class Run extends Console{

		public $config;
		public $database;
		public $db_driver;
		public $db_params;

		public $migrations_folder;
		public $migrations_files;
		public $namespace_classes;
		public $older_migrations=array();

		protected $result = true;

		public function __construct(){
			$this->migrations_folder = fx_path("system/migrations");
			$this->namespace_classes = "\\System\\Migrations";

			$this->config = Config::getInstance();
			$this->database = Database::getInstance();
			$this->db_driver = $this->database->getDbDriver();
			$this->db_params = $this->config->database[$this->db_driver];
		}

		public function execute(){
			$this->checkDb();
			$this->getOlderMigrations();
			$this->getMigrationsFiles();
			$this->migrateAllFiles();

			return $this->result;
		}

		public function checkDb(){
			$this->database
				->setCharset($this->db_params['sql_charset'])
				->setCollate($this->db_params['collate'])
				->makeDb($this->db_params['base']);
			return $this;
		}

		public function getOlderMigrations(){
			if($this->database->showTables()){
				$this->older_migrations = Database::select('mg_name')
					->from('migrations')
					->get()
					->allAsArray();
				if($this->older_migrations){
					$this->older_migrations = fx_reverse_array($this->older_migrations)['mg_name'];
				}
			}
			return $this;
		}

		public function getMigrationsFiles(){
			foreach(scandir($this->migrations_folder) as $file){
				if($file == '.' || $file == '..' || is_dir("{$this->migrations_folder}/{$file}")){ continue; }
				$file_name = pathinfo($file,PATHINFO_FILENAME);
				preg_match_all("@([a-z])|([0-9])@si",$file_name,$matches);
				$class = implode('',$matches[1]) . implode('',$matches[2]);
				$this->migrations_files[] = array(
					'class'		=> "{$this->namespace_classes}\\{$class}",
					'path'		=> "{$this->migrations_folder}/{$file}",
					'name'		=> $file_name,
				);
			}
			return $this;
		}

		public function migrateAllFiles(){
			foreach($this->migrations_files as $file){
				if(in_array($file['name'],$this->older_migrations)){
					$this->skipped($file['name']);
					continue;
				}
				fx_import_file($file['path'],Kernel::IMPORT_INCLUDE_ONCE);
				$this->callMigrationObjectMethods(new $file['class']());
				$this->insertNewMigrationToDb($file['name']);
				$this->success($file['name']);
			}
			return $this;
		}

		public function callMigrationObjectMethods($migration_object){
			foreach(get_class_methods($migration_object) as $method){
				call_user_func(array($migration_object,$method));
			}
			return $this;
		}

		public function insertNewMigrationToDb($file_name){
			return Database::insert('migrations')
				->value('mg_name',$file_name)
				->get()->id();
		}

		public function success($file_name){
			return Paint::exec(function(Types $print)use($file_name){
				$print->string(fx_lang('cli.migration'))->print();
				$print->string($file_name)->fon('green')->print();
				$print->string(' ' . fx_lang('cli.successful'))->color('light_green')->print()->eol();
			});
		}
		public function skipped($file_name){
			return Paint::exec(function(Types $print)use($file_name){
				$print->string(fx_lang('cli.migration'))->print();
				$print->string($file_name)->fon('red')->print();
				$print->string(' ' . fx_lang('cli.skipped'))->color('light_red')->print()->eol();
			});
		}
















	}














