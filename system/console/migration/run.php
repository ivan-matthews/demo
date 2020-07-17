<?php

	#CMD: php cli migration run
	#DSC: migration all migrations files to db
	#EXM: php cli migration run

	namespace System\Console\Migration;

	use Core\Classes\Console;
	use Core\Classes\Paint;
	use Core\Classes\Database;
	use Core\Classes\Config;

	class Run extends Console{

		private $config;
		private $database;
		private $db_driver;
		private $db_params;

		protected $migrations_folder;
		protected $migrations_files;
		protected $namespace_classes;
		protected $older_migrations=array();

		protected $result;

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

			return $this;
		}

		protected function checkDb(){
			$this->database
				->setCharset($this->db_params['sql_charset'])
				->setCollate($this->db_params['collate'])
				->makeDb($this->db_params['base']);
			return $this;
		}

		protected function getOlderMigrations(){
			if($this->database->showTables()){
				$this->older_migrations = Database::select('name')
					->from('migrations')
					->getArray();
				if($this->older_migrations){
					$this->older_migrations = fx_reverse_array($this->older_migrations)['name'];
				}
			}
			return $this;
		}

		protected function getMigrationsFiles(){
			foreach(scandir($this->migrations_folder) as $file){
				if($file == '.' || $file == '..'){ continue; }
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

		protected function migrateAllFiles(){
			foreach($this->migrations_files as $file){
				if(in_array($file['name'],$this->older_migrations)){
					$this->skipped($file['name']);
					continue;
				}
				include_once $file['path'];
				$this->callMigrationObjectMethods(new $file['class']());
				$this->insertNewMigrationToDb($file['name']);
				$this->success($file['name']);
			}
			return $this;
		}

		protected function callMigrationObjectMethods($migration_object){
			foreach(get_class_methods($migration_object) as $method){
				call_user_func(array($migration_object,$method));
			}
			return $this;
		}

		protected function insertNewMigrationToDb($file_name){
			return Database::insert('migrations')
				->value('name',$file_name)
				->getId();
		}

		protected function success($file_name){
			return Paint::exec(function(Paint $print)use($file_name){
				$print->string('Migration ')->toPaint();
				$print->string($file_name)->fon('green')->toPaint();
				$print->string(' successful')->color('cyan')->toPaint();
				$print->eol();
			});
		}
		protected function skipped($file_name){
			return Paint::exec(function(Paint $print)use($file_name){
				$print->string('Migration ')->toPaint();
				$print->string($file_name)->fon('red')->toPaint();
				$print->string(' skipped ')->color('yellow')->toPaint();
				$print->eol();
			});
		}
















	}














