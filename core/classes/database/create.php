<?php

	/*
		Database::makeTable('users', function(\Core\Database\Create $table){
			$table->bigint('id')->unsigned()->autoIncrement()->primary();

			$table->varchar('first_name')->index()->nullable();
			$table->varchar('phone',20)->index()->nullable();
			$table->int('birth_day',2)->index()->nullable();
			$table->longtext('activities')->fullText()->nullable();
			$table->bigint('date_log')->index()->nullable();
			$table->varchar('log_type')->index()->nullable();
			$table->varchar('type')->index()->defaults('u');

			$table->add_timestamps(); // added fields `date_created`, `date_updated`, `date_deleted`
			$table->exec();
		});
	*/

	namespace Core\Classes\Database;

	use Core\Classes\Config;
	use Core\Classes\Database\Connect\MySQLi;
	use Core\Classes\Database\Interfaces\Create\Create as CreateInterface;

	class Create implements CreateInterface{

		private $database;
		/** @var MySQLi */
		private $database_object;
		protected $config;
		protected $db_driver;
		protected $engine=array();

		protected $create;
		protected $table;

		protected $field;
		protected $fields=array();
		protected $indexes=array();
		protected $defaults=array();

		public function __construct($table, Database $database){
			$this->database = $database;
			$this->config = Config::getInstance();
			$this->db_driver = $this->database->getDbDriver();
			$this->engine['table_engine'] = $this->config->database[$this->db_driver]['engine'];
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
			$this->indexes=array();
			$this->defaults=array();
		}

		public function exec(){
			$this->connect();
			$result = $this->database_object->makeTable(
				$this->table,
				$this->fields,
				$this->indexes,
				$this->defaults,
				$this->engine
			);
//			$this->removeProps();
			return $result;
		}
		public function engine($engine){
			$this->engine['table_engine'] = $engine;
			return $this;
		}
		public function tableCharset($charset){
			$this->engine['table_charset'] = $charset;
			return $this;
		}
		public function tableCollate($collate){
			$this->engine['table_collate'] = $collate;
			return $this;
		}
		public function add_timestamps($fields_prefix){
			$this->bigint( "{$fields_prefix}date_created")->nullable()->index();
			$this->bigint( "{$fields_prefix}date_updated")->nullable()->index();
			$this->bigint( "{$fields_prefix}date_deleted")->nullable()->index();
			return true;
		}

		/*
		 * FIELDS
		*/

		public function char($field,$long=4){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function varchar($field,$long=191){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function tinytext($field,$long=null){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function text($field,$long=255){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function mediumtext($field,$long=null){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function largetext($field,$long=255){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function longtext($field,$long=null){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function boolean($field,$long=null){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function tinyint($field,$long=11){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function smallint($field,$long=11){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function mediumint($field,$long=11){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function int($field,$long=11){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function bigint($field,$long=255){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__,'long'=>$long);
			return $this;
		}
		public function decimal($field,$start=5,$end=2){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function float($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function double($field,$start=15,$end=8){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function date($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function time($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function datetime($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function timestamp($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function year($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function enum($field,$array=array()){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function set($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function tinyblob($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function blob($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function mediumblob($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		public function longblob($field){
			$this->field = $field;
			$this->fields[$this->field] = array('name'=>$this->field,'type'=>__FUNCTION__);
			return $this;
		}
		/*
		 * 		INDEXES
		*/
		public function primary($key=false){
			if(!$key){ $key = $this->field; }
			$this->indexes[$this->field] = array('type'=>'primary_key','key'=>$key);
			return $this;
		}
		public function unique($key=false){
			if(!$key){ $key = $this->field; }
			$this->indexes[$this->field] = array('type'=>'unique','key'=>$key);
			return $this;
		}
		public function index($key=false){
			if(!$key){ $key = $this->field; }
			$this->indexes[$this->field] = array('type'=>'index','key'=>$key);
			return $this;
		}
		public function fullText($key=false){
			if(!$key){ $key = $this->field; }
			$this->indexes[$this->field] = array('type'=>'fulltext','key'=>$key);
			return $this;
		}

		/*
		 * 		DEFAULTS
		*/
		public function notNull(){
			$this->defaults[$this->field][] = 'not_null';
			return $this;
		}
		public function currentTimestamp(){
			$this->defaults[$this->field][] = 'current_timestamp';
			return $this;
		}
		public function nullable(){
			$this->defaults[$this->field][] = 'nullable';
			return $this;
		}
		public function autoIncrement(){
			$this->defaults[$this->field][] = 'auto_increment';
			return $this;
		}
		public function comment($comment){
			$this->defaults[$this->field][] = array('value'=>$comment,'key'=>'comment');
			return $this;
		}
		public function defaults($defaults){
			$this->defaults[$this->field][] = array('value'=>$defaults,'key'=>'default');
			return $this;
		}
		public function unsigned(){
			$this->defaults[$this->field][] = 'unsigned';
			return $this;
		}
		public function bin(){
			$this->defaults[$this->field][] = 'binary';
			return $this;
		}
		public function zerofill(){
			$this->defaults[$this->field][] = 'zerofill';
			return $this;
		}
		public function character($character="utf8mb4",$collate="utf8mb4_unicode_ci"){
			$this->defaults[$this->field][] =
				array(
					'character'=>$character,
					'collate'=>$collate
				);
			return $this;
		}


















	}














