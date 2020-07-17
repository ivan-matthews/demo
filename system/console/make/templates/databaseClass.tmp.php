<?php

	namespace Core\Database\Connect;

	use Core\Classes\Config;

	class __class_name__{

		private static $instance;

		protected $fields = array(
			'char'				=> '',
			'varchar'			=> '',
			'tinytext'			=> '',
			'text'				=> '',
			'mediumtext'		=> '',
			'largetext'			=> '',
			'longtext'			=> '',
			'boolean'			=> '',
			'tinyint'			=> '',
			'smallint'			=> '',
			'mediumint'			=> '',
			'int'				=> '',
			'bigint'			=> '',
			'decimal'			=> '',
			'float'				=> '',
			'double'			=> '',
			'date'				=> '',
			'time'				=> '',
			'datetime'			=> '',
			'timestamp'			=> '',
			'year'				=> '',
			'enum'				=> '',
			'set'				=> '',
			'tinyblob'			=> '',
			'blob'				=> '',
			'mediumblob'		=> '',
			'longblob'			=> '',
		);
		protected $indexes = array(
			'primary_key'		=> '',
			'unique'			=> '',
			'index'				=> '',
			'fulltext'			=> '',
		);
		protected $defaults = array(
			'not_null'			=> '',
			'auto_increment'	=> '',
			'comment'			=> '',
			'unsigned'			=> '',
			'binary'			=> '',
			'zerofill'			=> '',
			'nullable'			=> '',
			'default'			=> '',
			'current_timestamp'	=> '',
		);

		protected $__db_class_key__;
		protected $params;
		protected $config;

		public $query;
		protected $database;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->params[$key])){
				return $this->params[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->params[$name] = $value;
			return $this->params[$name];
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->params = $this->config->database['__db_class_key__'];
		}

		public function exec($sql,$params=array()){
			$this->query[] = $sql;
		}

		public function __destruct(){

		}

		public function selectDB($database_name){
			$this->database = $database_name;
		}

		public function prepare($sql,$params){

		}

		public function prepareValue($value){

		}

		public function escape($string){

		}

		public function setLcMessages($lang){

		}

		public function setSqlMode($sql_mode){

		}

		public function getItemAsArray($result){

		}

		public function getArray($result){

		}

		public function getItemAsObject($result){

		}

		public function getObject($result){

		}

		public function lastId(){

		}

		public function freeResult($result){

		}

		public function numRows($result){

		}

		public function affectedRows(){

		}

		public function showTables($database){

		}

		public function showDatabases(){

		}

		public function makeDb($database,$charset,$collate){

		}

		public function dropDb($database){

		}

		public function dropTable($table){

		}

		public function truncateTable($table){

		}

		public function showIndex($table){

		}

		public function delete($from_table,$where,$nested_query,$using_tables,$limit,$offset,$order,$group,$preparing){

		}

		public function insert($table,$fields,$nested_query,$update,$update_nested_query,$preparing){

		}

		public function select($fields,$from_table,$where,$nested_query,$join,$limit,$offset,$order,$group,$preparing){

		}

		public function update($fields,$table,$where,$nested_query,$join,$limit,$offset,$preparing){

		}

		public function makeTable($table,$fields,$indexes,$defaults,$engine){

		}

		public function alterTable($table,$fields){

		}

	}














