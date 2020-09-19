<?php

	namespace Core\Classes\Database\Connect;

	use Core\Classes\Config;
	use Core\Classes\Response\Response;
	use Core\Classes\Error;

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

		private $insert_fields;
		private $insert_values;
		private $update_insert_string;

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
			$time = microtime(true);
			$backtrace = debug_backtrace();

			$this->config = Config::getInstance();
			$this->params = $this->config->database['__db_class_key__'];
		}

		private function prepareBackTrace($debug_back_trace,$index,$key){
			return isset($debug_back_trace[$index][$key]) ? $debug_back_trace[$index][$key] : null;
		}

		public function exec($sql,$params=array()){}

		public function __destruct(){
			$this->close();
		}

		protected function close(){}

		public function selectDB($database_name){}

		public function prepare($sql,$params){}

		public function prepareValue($value){}

		public function escape($string){}

		public function setLcMessages($lang){}

		public function setSqlMode($sql_mode){}

		private function setTimezone(){}

		protected function getFields($fields){}
		protected function getTables($tables){}
		protected function getWhere($where){}
		protected function getNested($nested_query){}

		protected function getJoin($join){}

		protected function getUsing($tables){}
		protected function getLimit($limit){}
		protected function getOffset($offset){}
		protected function getOrder($order){}
		protected function getGroup($group){}

		private function getSortingFromArray($order){}

		private function getSort($sorting,$order){}

		public function getAll($result,$resulttype=1){}

		public function getItemAsArray($result){}

		public function getArray($result){}

		public function getItemAsObject($result){}

		public function getObject($result){}

		public function lastId(){}

		public function freeResult($result){}

		public function numRows($result){}

		public function affectedRows(){}

		public function showTables($database){}

		public function showDatabases(){}

		public function showColumns($table){}

		public function makeDb($database,$charset,$collate){}

		public function dropDb($database){}

		public function dropTable($table){}

		public function truncateTable($table){}

		public function showIndex($table){}

		public function delete($from_table,$where,$nested_query,$using_tables,$limit,$offset,$order,$sort,$group,$preparing){}

		public function insert($table,$fields,$nested_query,$update,$update_nested_query,$preparing){}

		public function select($fields,$from_table,$where,$nested_query,$join,$limit,$offset,$order,$sort,$group,$preparing){}

		public function update($fields,$table,$where,$nested_query,$join,$limit,$offset,$order,$sort,$group,$preparing){}

		protected function getInsertString($fields){}

		protected function getInsertStringFromNestedQuery($fields){}

		protected function getInsertFields(){}

		protected function getInsertValues(){}

		protected function getUpdateStringForInsert($update){}

		protected function getUpdateNestedStringForInsert($update){}

		protected function removeProps(){}

		public function makeTable($table,$fields,$indexes,$defaults,$engine){}

/*--------------------------------------------------------------------------------------------------------------------*/

		public function alterTable($table,$fields){}

		private function makeStringFromFieldParams($field_name,$field){}

		private function addColumn($field_name,$field){}

		private function dropColumn($field_name,$field){}

		private function changeColumn($field_name,$field){}

		private function modifyColumn($field_name,$field){}

		private function addIndex($field_name,$field){}

		private function addPrimary($field_name,$field){}

		private function addFulltext($field_name,$field){}

		private function addUnique($field_name,$field){}

		private function dropIndex($field_name,$field){}

		private function dropPrimary($field_name,$field){}

		private function dropFulltext($field_name,$field){}

		private function dropUnique($field_name,$field){}

		private function dropAutoIncrement($field_name,$field){}

		private function addAutoIncrement($field_name,$field){}


	}














