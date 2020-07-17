<?php

	/*
		Database::alterTable('testovoe',function(\Core\Database\Interfaces\Alter\Alter $alt){
			$alt->field('a')->addColumn()->bigint()->unsigned()->notNull();
			$alt->field('a')->modifyColumn()->varchar(121);
			$alt->field('a')->changeColumn('new_a')->bigint()->unsigned()->notNull();
			$alt->field('new_a')->dropColumn();
			$alt->field('id')->dropAutoIncrement()->varchar(191)->notNull();
			$alt->field('id')->addAutoIncrement()->bigint(11)->notNull();

			$alt->field('s')->addColumn()->bigint()->unsigned()->notNull()->addIndex();
			$alt->field('t')->addColumn()->bigint()->unsigned()->notNull()->addPrimary();
			$alt->field('g')->addColumn()->bigint()->unsigned()->notNull()->addFulltext();
			$alt->field('h')->addColumn()->bigint()->unsigned()->notNull()->addUnique();
			$alt->field('q')->addColumn()->bigint()->unsigned()->notNull()->dropIndex();
			$alt->field('w')->addColumn()->bigint()->unsigned()->notNull()->dropFulltext();
			$alt->field('e')->addColumn()->bigint()->unsigned()->notNull()->dropPrimary();
			$alt->field('r')->addColumn()->bigint()->unsigned()->notNull()->dropUnique();

			fx_pre($alt->exec());
		});

		Database::alterTable('tablitsa',function(\Core\Database\Interfaces\Alter\Alter $a){
			$a->field('id')->changeColumn('dia')->bigint()->unsigned()->autoIncrement();
			$a->exec();
		});
	*/

	namespace Core\Database;

	use Core\Classes\Config;
	use Core\Classes\Database;
	use Core\Database\Connect\MySQLi;
	use Core\Database\Interfaces\Alter\Alter as AlterInterface;

	class Alter implements AlterInterface{

		private $database;
		/** @var MySQLi */
		private $database_object;
		protected $config;
		protected $engine;
		protected $db_driver;

		protected $alter;
		protected $table;

		protected $fields;
		protected $field;

		public function __construct($table, Database $database){
			$this->database = $database;
			$this->config = Config::getInstance();
			$this->db_driver = $this->database->getDbDriver();
			$this->engine = $this->config->database[$this->db_driver]['engine'];
			$this->table = $table;
		}

		private function connect(){
			$this->database_object = $this->database->getDbObject();
			return $this;
		}

		protected function removeProps(){
			$this->table=null;
			$this->field=null;
			$this->fields=array();
		}

		public function exec(){
			$this->connect();
			$result = $this->database_object->alterTable(
				$this->table,
				$this->fields
			);
//			$this->removeProps();
			return $result;
		}
		public function field($field){
			$this->field = $field;
			return $this;
		}

		public function addColumn(){
			$this->fields[$this->field]['method'] = __FUNCTION__;
			return $this;
		}
		public function dropColumn(){
			$this->fields[$this->field]['method'] = __FUNCTION__;
			return $this;
		}
		public function changeColumn($new_name){
			$this->fields[$this->field]['method'] = __FUNCTION__;
			$this->fields[$this->field]['new_name'] = $new_name;
			return $this;
		}
		public function modifyColumn(){
			$this->fields[$this->field]['method'] = __FUNCTION__;
			return $this;
		}
		public function dropAutoIncrement(){
			$this->fields[$this->field]['method'] = __FUNCTION__;
			return $this;
		}
		public function addAutoIncrement(){
			$this->fields[$this->field]['method'] = __FUNCTION__;
			return $this;
		}

		public function addIndex($index=false){
			$this->fields[$this->field]['index_key'] = $index;
			$this->fields[$this->field]['index_method'] = __FUNCTION__;
			return $this;
		}
		public function addPrimary($index=false){
			$this->fields[$this->field]['index_key'] = $index;
			$this->fields[$this->field]['index_method'] = __FUNCTION__;
			return $this;
		}
		public function addFulltext($index=false){
			$this->fields[$this->field]['index_key'] = $index;
			$this->fields[$this->field]['index_method'] = __FUNCTION__;
			return $this;
		}
		public function addUnique($index=false){
			$this->fields[$this->field]['index_key'] = $index;
			$this->fields[$this->field]['index_method'] = __FUNCTION__;
			return $this;
		}
		public function dropFulltext($index=false){
			$this->fields[$this->field]['index_key'] = $index;
			$this->fields[$this->field]['index_method'] = __FUNCTION__;
			return $this;
		}
		public function dropIndex($index=false){
			$this->fields[$this->field]['index_key'] = $index;
			$this->fields[$this->field]['index_method'] = __FUNCTION__;
			return $this;
		}
		public function dropPrimary($index=false){
			$this->fields[$this->field]['index_key'] = $index;
			$this->fields[$this->field]['index_method'] = __FUNCTION__;
			return $this;
		}
		public function dropUnique($index=false){
			$this->fields[$this->field]['index_key'] = $index;
			$this->fields[$this->field]['index_method'] = __FUNCTION__;
			return $this;
		}

/*------------------------------------------------------------------------------------------------------------------*/

		public function char($long=4){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function varchar($long=191){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function tinytext($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function text($long=255){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function mediumtext($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function largetext($long=255){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function longtext($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function boolean($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function tinyint($long=11){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function smallint($long=11){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function mediumint($long=11){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function int($long=11){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function bigint($long=11){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function decimal($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function float($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function double($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function date($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function time($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function datetime($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function timestamp($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function year($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function enum($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function set($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function tinyblob($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function blob($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function mediumblob($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}
		public function longblob($long=null){
			$this->fields[$this->field]['type'] = __FUNCTION__;
			$this->fields[$this->field]['long'] = $long;
			return $this;
		}

/*------------------------------------------------------------------------------------------------------------------*/

		public function notNull(){
			$this->fields[$this->field]['definition']['not_null'] = true;
			return $this;
		}
		public function currentTimestamp(){
			$this->fields[$this->field]['definition']['current_timestamp'] = true;
			return $this;
		}
		public function nullable(){
			$this->fields[$this->field]['definition']['nullable'] = true;
			return $this;
		}
		public function autoIncrement(){
			$this->fields[$this->field]['definition']['auto_increment'] = true;
			return $this;
		}
		public function comment($comment){
			$this->fields[$this->field]['definition']['comment'] = $comment;
			return $this;
		}
		public function defaults($defaults){
			$this->fields[$this->field]['definition']['default'] = $defaults;
			return $this;
		}
		public function unsigned(){
			$this->fields[$this->field]['definition']['unsigned'] = true;
			return $this;
		}
		public function bin(){
			$this->fields[$this->field]['definition']['binary'] = true;
			return $this;
		}
		public function zerofill(){
			$this->fields[$this->field]['definition']['zerofill'] = true;
			return $this;
		}

	}