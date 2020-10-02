<?php

	namespace Core\Classes\Database\Connect;

	use Core\Classes\Config;
	use Core\Classes\Response\Response;
	use Core\Classes\Error;

	class MySQL{

		private static $instance;

		protected $fields = array(
			'char'			=> 'CHAR',
			'varchar'		=> 'VARCHAR',
			'tinytext'		=> 'TINYTEXT',
			'text'			=> 'TEXT',
			'mediumtext'	=> 'MEDIUMTEXT',
			'largetext'		=> 'LARGETEXT',
			'longtext'		=> 'LONGTEXT',
			'boolean'		=> 'BOOLEAN',
			'tinyint'		=> 'TINYINT',
			'smallint'		=> 'SMALLINT',
			'mediumint'		=> 'MEDIUMINT',
			'int'			=> 'INT',
			'bigint'		=> 'BIGINT',
			'decimal'		=> 'DECIMAL',
			'float'			=> 'FLOAT',
			'double'		=> 'DOUBLE',
			'date'			=> 'DATE',
			'time'			=> 'TIME',
			'datetime'		=> 'DATETIME',
			'timestamp'		=> 'TIMESTAMP',
			'year'			=> 'YEAR',
			'enum'			=> 'ENUM',
			'set'			=> 'SET',
			'tinyblob'		=> 'TINYBLOB',
			'blob'			=> 'BLOB',
			'mediumblob'	=> 'MEDIUMBLOB',
			'longblob'		=> 'LONGBLOB',
		);
		protected $indexes = array(
			'primary_key'	=> 'PRIMARY KEY',
			'unique'		=> 'UNIQUE',
			'index'			=> 'INDEX',
			'fulltext'		=> 'FULLTEXT',
		);
		protected $defaults = array(
			'not_null'		=> 'NOT NULL',
			'auto_increment'=> 'AUTO_INCREMENT',
			'comment'		=> 'COMMENT',
			'unsigned'		=> 'UNSIGNED',
			'binary'		=> 'BINARY',
			'zerofill'		=> 'ZEROFILL',
			'nullable'		=> 'DEFAULT NULL',
			'default'		=> 'DEFAULT',
			'current_timestamp'	=> 'NULL DEFAULT CURRENT_TIMESTAMP',
		);

		private $insert_fields;
		private $insert_values;
		private $update_insert_string;

		protected $mysqli;
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
			$this->params = $this->config->database['mysql'];

			mysqli_report(MYSQLI_REPORT_STRICT);

			try{
				$this->mysqli = new \MySQLi(
					$this->params['host'],
					$this->params['user'],
					$this->params['pass'],
					'',
					(int)$this->params['port'],
					$this->params['socket']
				);
				if($this->config->core['debug_enabled']){
					Response::_debug('database')
						->setQuery('DATABASE CONNECTION;')
						->setTime($time)
						->setTrace($backtrace)
						->setFile($this->prepareBackTrace($backtrace,8,'file'))
						->setClass($this->prepareBackTrace($backtrace,8,'class'))
						->setFunction($this->prepareBackTrace($backtrace,8,'function'))
						->setType($this->prepareBackTrace($backtrace,8,'type'))
						->setLine($this->prepareBackTrace($backtrace,8,'line'))
						->setArgs($this->prepareBackTrace($backtrace,8,'args'))
					;
				}

			}catch(\Exception $e){
				Error::getInstance(
					$e->getCode(),
					$e->getMessage(),
					$e->getFile(),
					$e->getLine(),
					$backtrace
				);
			}

			$this->selectDB($this->params['base']);
			$this->setTimezone();
			$this->setLcMessages($this->params['lc_messages']);

			$this->mysqli->set_charset($this->params['sql_charset']);
			$this->setSqlMode($this->params['clear_sql_mode']);
		}

		private function prepareBackTrace($debug_back_trace,$index,$key){
			return isset($debug_back_trace[$index][$key]) ? $debug_back_trace[$index][$key] : null;
		}

		public function exec($sql,$params=array()){
			$time = microtime(true);
			$backtrace = debug_backtrace();

			if($params){
				$sql = $this->prepare($sql,$params);
			}
			$this->query[] = $sql;
			$result = $this->mysqli->query($sql);
			if($this->config->core['debug_enabled']){
				Response::_debug('database')
					->setQuery($sql)
					->setTime($time)
					->setTrace($backtrace)
					->setFile($this->prepareBackTrace($backtrace,8,'file'))
					->setClass($this->prepareBackTrace($backtrace,8,'class'))
					->setFunction($this->prepareBackTrace($backtrace,8,'function'))
					->setType($this->prepareBackTrace($backtrace,8,'type'))
					->setLine($this->prepareBackTrace($backtrace,8,'line'))
					->setArgs($this->prepareBackTrace($backtrace,4,'args'))
				;
			}

			if(!$this->mysqli->errno){
				return $result;
			}
			$error_file = isset($backtrace[1]['file']) ? $backtrace[1]['file'] : null;
			$error_line = isset($backtrace[1]['line']) ? $backtrace[1]['line'] : null;
			Error::getInstance(
				$this->mysqli->error_list[0]['errno'],
				$this->mysqli->error_list[0]['error'],
				$error_file,
				$error_line,
				$backtrace,
				$sql
			);
			return null;
		}

		public function __destruct(){
			$this->close();
		}

		protected function close(){
			$this->mysqli->close();
			return $this;
		}

		public function selectDB($database_name){
			$this->database = $database_name;
			$this->mysqli->select_db($database_name);
			return $this;
		}

		public function prepare($sql,$params){
			$array_keys = array();
			$array_values = array();
			foreach($params as $key=>$value){
				$array_keys[] = $key;
				$array_values[] = $this->prepareValue($value);
			}
			$sql = str_replace($array_keys,$array_values,$sql);
			return $sql;
		}

		public function prepareValue($value){
			if(is_array($value)){ return "'" . $this->escape(fx_json_encode($value,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)) . "'"; }
			if(is_null($value)){ return "NULL"; }
			if(is_bool($value)){ return (bool)$value; }
			if(fx_equal($value,'')){ return "NULL"; }
			if(empty($value) && !is_string($value)){ return "0"; }
			$value = $this->escape(trim($value));
			return "'{$value}'";
		}

		public function escape($string){
			return $this->mysqli->real_escape_string($string);
		}

		public function setLcMessages($lang){
			$this->exec("SET lc_messages = '{$lang}';");
			return $this;
		}

		public function setSqlMode($sql_mode){
			$this->exec("SET sql_mode='{$sql_mode}';");
			return $this;
		}

		private function setTimezone(){
			$this->exec("SET `time_zone` = '" . date('P') . "';");
			return $this;
		}

		protected function getFields($fields){
			if(is_array($fields)){
				return implode(', ', $fields) . " ";
			}
			return "* ";
		}
		protected function getTables($tables){
			if(is_array($tables)){
				return implode(', ', $tables) . " ";
			}
			return "{$tables} ";
		}
		protected function getWhere($where){
			if($where){
				return "\n\tWHERE {$where} ";
			}
			return null;
		}
		protected function getNested($nested_query){
			if($nested_query){
				$nested_query = trim($nested_query,' ');
				return "{$nested_query} ";
			}
			return null;
		}

		protected function getJoin($join){
			if($join){
				$result = "";
				foreach($join as $item){
					$result .= "\n\t{$item['type']} JOIN {$item['table']} \n\t\tON {$item['query']}";
				}
				return $result;
			}
			return null;
		}

		protected function getUsing($tables){
			if($tables){
				$result = $this->getTables($tables);
				return "\n\tUSING {$result}";
			}
			return null;
		}
		protected function getLimit($limit){
			$limit = (int)$limit;
			if($limit){
				return "\n\tLIMIT {$limit} ";
			}
			return null;
		}
		protected function getOffset($offset){
			$offset = (int)$offset;
			if($offset){
				return "\n\t\tOFFSET {$offset} ";
			}
			return null;
		}
		protected function getOrder($order){
			if($order){
				return "\n\tORDER BY " . $this->getSortingFromArray($order) . " ";
			}
			return null;
		}
		protected function getGroup($group){
			if($group){
				if(is_array($group)){
					$group = implode(', ', $group);
				}
				return "\n\tGROUP BY {$group} ";
			}
			return null;
		}

		private function getSortingFromArray($order){
			$order = implode(', ', $order);
			return "{$order}";
		}

		private function getSort($sorting,$order){
			if($order){
				return "\n\t\t{$sorting} ";
			}
			return null;
		}

		/**
		 * @param object $result
		 * @param int $resulttype
		 * @return array
		 */
		public function getAll($result,$resulttype=MYSQLI_ASSOC){
			if($result){
				$data = $result->fetch_all($resulttype);
				$this->freeResult($result);
				return $data;
			}
			return array();
		}

		/**
		 * @param object $result
		 * @return array
		 */
		public function getItemAsArray($result){
			if($result){
				$data = $result->fetch_assoc();
				$this->freeResult($result);
				return $data;
			}
			return array();
		}

		/**
		 * @param object $result
		 * @return array
		 */
		public function getArray($result){
			if($result){
				$data=array();
				while($item = $result->fetch_assoc()){
					$data[] = $item;
				}
				$this->freeResult($result);
				return $data;
			}
			return array();
		}

		/**
		 * @param object $result
		 * @return bool
		 */
		public function getItemAsObject($result){
			if($result){
				$data = $result->fetch_object();
				$this->freeResult($result);
				return $data;
			}
			return false;
		}

		/**
		 * @param object $result
		 * @return array|bool
		 */
		public function getObject($result){
			if($result){
				$data=array();
				while($item = $result->fetch_object()){
					$data[] = $item;
				}
				$this->freeResult($result);
				return $data;
			}
			return false;
		}

		public function lastId(){
			return $this->mysqli->insert_id;
		}

		/**
		 * @param object $result
		 * @return $this
		 */
		public function freeResult($result){
			if($result){
				$result->close();
			}
			return $this;
		}

		public function numRows($result){
			return $result->num_rows;
		}

		public function affectedRows(){
			return $this->mysqli->affected_rows;
		}

		public function showTables($database){
			$database = $database ? $database : $this->database;
			$sql = "SHOW TABLES FROM {$database};";
			$result = $this->exec($sql);
			if($result){
				$data=array();
				while($item = $result->fetch_assoc()){
					$data[] = $item["Tables_in_{$database}"];
				}
				$this->freeResult($result);
				return $data;
			}
			return array();
		}

		public function showDatabases(){
			$sql = "SHOW DATABASES;";
			$result = $this->exec($sql);
			if($result){
				$data=array();
				while($item = $result->fetch_assoc()){
					$data[] = $item['Database'];
				}
				$this->freeResult($result);
				return $data;
			}
			return array();
		}

		public function showColumns($table){
			$sql = "SHOW COLUMNS FROM {$table};";
			$result = $this->exec($sql);
			if($result){
				$data=array();
				while($item = $result->fetch_assoc()){
					$data[] = $item['Field'];
				}
				$this->freeResult($result);
				return $data;
			}
			return array();
		}

		public function makeDb($database,$charset,$collate){
			$sql = "CREATE DATABASE IF NOT EXISTS {$database}";
			if($charset){ $sql .= "\n\t DEFAULT CHARSET={$charset}"; }
			if($collate){ $sql .= "\n\t COLLATE {$collate}"; }
			$sql .= ';';

			$this->exec($sql);
			if(!$this->mysqli->errno){
				$this->selectDB($database);
				return true;
			}
			return null;
		}

		public function dropDb($database){
			$sql = "DROP DATABASE IF EXISTS {$database};";
			$this->exec($sql);
			if(!$this->mysqli->errno){
				return true;
			}
			return null;
		}

		public function dropTable($table){
			$sql = "DROP TABLE IF EXISTS ";
			$sql .= $this->getTables($table);
			$sql .= ';';
			$this->exec($sql);
			if(!$this->mysqli->errno){
				return true;
			}
			return null;
		}

		public function truncateTable($table){
			$sql = "TRUNCATE TABLE ";
			$sql .= $this->getTables($table);
			$sql .= ';';
			$this->exec($sql);
			if(!$this->mysqli->errno){
				return true;
			}
			return null;
		}

		public function showIndex($table){
			$sql = "SHOW INDEX FROM `{$table}`;";
			$result = $this->exec($sql);
			if($result){
				$data=array();
				while($item = $result->fetch_assoc()){
					$data[] = $item;
				}
				$this->freeResult($result);
				return $data;
			}
			return array();
		}

		public function delete($from_table,$where,$nested_query,$using_tables,$limit,$offset,$order,$sort,$group,$preparing){
			$query = 'DELETE FROM ';
			$query .= $this->getTables($from_table);
			$query .= $this->getUsing($using_tables);
			$query .= $this->getWhere($where);
			$query .= $this->getNested($nested_query);
			$query .= $this->getGroup($group);
			$query .= $this->getOrder($order);
			$query .= $this->getSort($sort,$order);
			$query .= $this->getLimit($limit);
			$query .= $this->getOffset($offset);

			return $this->exec(trim($query) . ";",$preparing);
		}

		public function insert($table,$fields,$nested_query,$update,$update_nested_query,$preparing){
			$this->removeProps();

			$this->getInsertString($fields);
			$this->getInsertStringFromNestedQuery($nested_query);
			$this->getUpdateStringForInsert($update);
			$this->getUpdateNestedStringForInsert($update_nested_query);

			$query = 'INSERT INTO ';
			$query .= $this->getTables($table);
			$query .= $this->getInsertFields();
			$query .= "\n\tVALUES";
			$query .= $this->getInsertValues();

			if($this->update_insert_string){
				$query .= " \n\t\tON DUPLICATE KEY UPDATE \n\t\t\t";
				$query .= trim($this->update_insert_string,", \n");
			}
			$query .= ';';

			return $this->exec($query,$preparing);
		}

		public function select($fields,$from_table,$where,$nested_query,$join,$limit,$offset,$order,$sort,$group,$preparing){
			$query = 'SELECT ';
			$query .= $this->getFields($fields);
			$query .= "\n\tFROM ";
			$query .= $this->getTables($from_table);
			$query .= $this->getJoin($join);
			$query .= $this->getWhere($where);
			$query .= $this->getNested($nested_query);
			$query .= $this->getGroup($group);
			$query .= $this->getOrder($order);
			$query .= $this->getSort($sort,$order);
			$query .= $this->getLimit($limit);
			$query .= $this->getOffset($offset);

			return $this->exec(trim($query) . ";",$preparing);
		}

		public function update($fields,$table,$where,$nested_query,$join,$limit,$offset,$order,$sort,$group,$preparing){
			$this->removeProps();

			$this->getUpdateStringForInsert($fields);
			$this->getUpdateNestedStringForInsert($nested_query);

			$query = "UPDATE ";
			$query .= $this->getTables($table);
			$query .= $this->getJoin($join);
			$query .= "\n\tSET ";
			$query .= trim($this->update_insert_string, ", \n");
			$query .= " \n";
			$query .= $this->getWhere($where);
			$query .= $this->getGroup($group);
			$query .= $this->getOrder($order);
			$query .= $this->getSort($sort,$order);
			$query .= $this->getLimit($limit);
			$query .= $this->getOffset($offset);

			return $this->exec(trim($query) . ";",$preparing);
		}

		protected function getInsertString($fields){
			if($fields){
				foreach($fields as $key=>$value){
					$this->insert_fields[] = "`{$key}`";
					foreach($value as $index=>$item){
						$this->insert_values[$index][$key] = $this->prepareValue($item);
					}
				}
			}
			return $this;
		}

		protected function getInsertStringFromNestedQuery($fields){
			if($fields){
				foreach($fields as $key=>$value){
					$this->insert_fields[] = "`{$key}`";
					foreach($value as $index=>$item){
						$this->insert_values[$index][$key] = "{$item}";
					}
				}
			}
			return $this;
		}

		protected function getInsertFields(){
			return "(" . implode(', ', $this->insert_fields) . ")";
		}

		protected function getInsertValues(){
			$result = '';
			foreach($this->insert_values as $value){
				$result .= "\t\t\t(" . implode(', ', $value) . "),\n";
			}
			return trim($result,",\n");
		}

		protected function getUpdateStringForInsert($update){
			if($update){
				foreach($update as $key=>$data){
					$data = $this->prepareValue($data);
					$this->update_insert_string .= "`{$key}`={$data}, \n";
				}
			}
			return $this;
		}

		protected function getUpdateNestedStringForInsert($update){
			if($update){
				foreach($update as $key=>$data){
					$this->update_insert_string .= "`{$key}`={$data}, \n";
				}
			}
			return $this;
		}

		protected function removeProps(){
			$this->insert_fields = null;
			$this->insert_values = null;
			$this->update_insert_string = null;
			return $this;
		}

		public function makeTable($table,$fields,$indexes,$defaults,$engine){
			if(!$fields){ return false; }
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}` (" . PHP_EOL;
			foreach($fields as $key=>$val){
				$long = isset($val['long']) ? "({$val['long']})" : null;
				$sql .= "\t`{$val['name']}` {$this->fields[$val['type']]}{$long}";
				if(isset($defaults[$key]) && is_array($defaults[$key])){
					foreach($defaults[$key] as $item){
						if(isset($item['key']) && isset($item['value'])){
							$sql .= " {$this->defaults[$item['key']]} '{$item['value']}'";
							continue;
						}
						if(isset($item['character']) && isset($item['collate'])){
							$sql .= " CHARACTER SET {$item['character']} COLLATE {$item['collate']}";
							continue;
						}
						$sql .= " {$this->defaults[$item]}";
					}
				}
				$sql .= "," . PHP_EOL;
			}
			if(isset($indexes) && is_array($indexes)){
				foreach($indexes as $ind=>$ex){
					$sql .= "\t\t{$this->indexes[$ex['type']]} {$ex['key']}_index (`{$ex['key']}`), " . PHP_EOL;
				}
			}
			$sql = trim($sql,', ' . PHP_EOL);
			$sql .= PHP_EOL;
			$sql .= ")";
			$sql .= "ENGINE = {$engine['table_engine']}";
			if(isset($engine['table_charset'])){ $sql .= ", CHARACTER SET {$engine['table_charset']}"; }
			if(isset($engine['table_collate'])){ $sql .= " COLLATE {$engine['table_collate']}"; }
			$sql .= ";";

			return $this->exec($sql);
		}

/*--------------------------------------------------------------------------------------------------------------------*/

		public function alterTable($table,$fields){
			if(!$fields){ return false; }
			$sql = "ALTER TABLE `{$table}`" . PHP_EOL;
			foreach($fields as $key=>$field){
				if(isset($field['method'])){
					$sql .= $this->{$field['method']}($key,$field) . "," . PHP_EOL;
				}
				if(isset($field['index_method'])){
					$sql .= $this->{$field['index_method']}($key,$field) . "," . PHP_EOL;
				}
			}
			$sql = trim($sql,",\n") . ";";
			return $this->exec($sql);
		}


		private function makeStringFromFieldParams($field_name,$field){
			$sql = '';
			if(isset($field['type'])){ $sql .= "{$this->fields[$field['type']]}"; }
			if(isset($field['long'])){ $sql .= "({$field['long']}) "; }
			if(isset($field['definition'])){
				foreach($field['definition'] as $key=>$val){
					if($val && is_bool($val)){
						$sql .= "{$this->defaults[$key]} ";
					}else{
						$sql .= "{$this->defaults[$key]} '{$val}'";
					}
				}
			}
			return $sql;
		}

		private function addColumn($field_name,$field){
			$sql = "\tADD COLUMN `{$field_name}` ";
			$sql .= $this->makeStringFromFieldParams($field_name,$field);
			return $sql;
		}

		private function dropColumn($field_name,$field){
			$sql = "\tDROP COLUMN `{$field_name}`";
			return $sql;
		}

		private function changeColumn($field_name,$field){
			$sql = "\tCHANGE COLUMN `{$field_name}` `{$field['new_name']}` ";
			$sql .= $this->makeStringFromFieldParams($field_name,$field);
			return $sql;
		}

		private function modifyColumn($field_name,$field){
			$sql = "\tMODIFY COLUMN `{$field_name}` ";
			$sql .= $this->makeStringFromFieldParams($field_name,$field);
			return $sql;
		}

		private function addIndex($field_name,$field){
			$field['index_key'] = $field['index_key'] ? $field['index_key'] : $field_name;
			$sql = "\tADD INDEX {$field['index_key']} ({$field['index_key']})";
			return $sql;
		}

		private function addPrimary($field_name,$field){
			$field['index_key'] = $field['index_key'] ? $field['index_key'] : $field_name;
			$sql = "\tADD PRIMARY KEY ({$field['index_key']})";
			return $sql;
		}

		private function addFulltext($field_name,$field){
			$field['index_key'] = $field['index_key'] ? $field['index_key'] : $field_name;
			$sql = "\tADD FULLTEXT {$field['index_key']} ({$field['index_key']})";
			return $sql;
		}

		private function addUnique($field_name,$field){
			$field['index_key'] = $field['index_key'] ? $field['index_key'] : $field_name;
			$sql = "\tADD UNIQUE {$field['index_key']} ({$field['index_key']})";
			return $sql;
		}

		private function dropIndex($field_name,$field){
			$field['index_key'] = $field['index_key'] ? $field['index_key'] : $field_name;
			$sql = "\tDROP INDEX {$field['index_key']}";
			return $sql;
		}

		private function dropPrimary($field_name,$field){
			$field['index_key'] = $field['index_key'] ? $field['index_key'] : $field_name;
			$sql = "\tDROP PRIMARY KEY";
			return $sql;
		}

		private function dropFulltext($field_name,$field){
			return $this->dropIndex($field_name,$field);
		}

		private function dropUnique($field_name,$field){
			return $this->dropIndex($field_name,$field);
		}

		private function dropAutoIncrement($field_name,$field){
			$sql = "\tDROP PRIMARY KEY, " . PHP_EOL;
			$field['new_name'] = $field_name;
			$sql .= $this->changeColumn($field_name,$field);
			return $sql;
		}

		private function addAutoIncrement($field_name,$field){
			$field['new_name'] = $field_name;
			$sql = $this->changeColumn($field_name,$field);
			$sql .= PHP_EOL . "\tAUTO_INCREMENT PRIMARY KEY";
			return $sql;
		}


	}














