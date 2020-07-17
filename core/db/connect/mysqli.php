<?php

	namespace Core\DB\Connect;

	use Core\Classes\Config;

	class MySQLi{

		private static $instance;

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
			$this->config = Config::getInstance();
			$this->params = $this->config->database['mysqli'];

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
			}catch(\Exception $e){

			}

			$this->selectDB($this->params['base']);
			$this->setTimezone();
			$this->setLcMessages($this->params['lc_messages']);

			$this->mysqli->set_charset($this->params['sql_charset']);
			$this->setSqlMode($this->params['clear_sql_mode']);
		}

		public function __destruct(){

		}

		public function selectDB($db_name){
			$this->database = $db_name;
			$this->mysqli->select_db($db_name);
			return $this;
		}

		public function exec($sql,$params=array()){
			if($params){
				$sql = $this->prepare($sql,$params);
			}
			$this->query[] = $sql;
			$result = $this->mysqli->query($sql);
			fx_pre($sql);
			if(!$this->mysqli->errno){
				return $result;
			}
			fx_die($this->mysqli->error_list);
			return false;
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
			if(empty($value) && !is_string($value)){ return "NULL"; }
			if(is_array($value)){ return "'" . $this->escape(json_encode($value)) . "'"; }
			if(is_null($value)){ return "NULL"; }
			if(is_bool($value)){ return (bool)$value; }
			if(fx_equal($value,'')){ return "NULL"; }
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
			if($this->params['clear_sql_mode']){
				$this->exec("SET sql_mode='{$sql_mode}';");
			}
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
		protected function getTable($from_table){
			$result = $this->getTableString($from_table);
			return "FROM {$result} ";
		}
		protected function getTableString($tables){
			if(is_array($tables)){
				return implode(', ', $tables);
			}
			return $tables;
		}
		protected function getWhere($where){
			if($where){
				return "WHERE {$where} ";
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
					$result .= "{$item['type']} JOIN {$item['table']} ON {$item['query']} \n";
				}
				return $result;
			}
			return null;
		}

		protected function getUsing($tables){
			if($tables){
				$result = $this->getTableString($tables);
				return "USING {$result} ";
			}
			return null;
		}
		protected function getLimit($limit){
			$limit = (int)$limit;
			if($limit){
				return "LIMIT {$limit} ";
			}
			return null;
		}
		protected function getOffset($offset){
			$offset = (int)$offset;
			if($offset){
				return "OFFSET {$offset} ";
			}
			return null;
		}
		protected function getOrder($order){
			if($order){
				return "ORDER BY " . $this->getSortingFromArray($order) . " ";
			}
			return null;
		}
		protected function getGroup($group){
			if($group){
				if(is_array($group)){
					$group = implode(', ', $group);
				}
				return "GROUP BY {$group} ";
			}
			return null;
		}

		private function getSortingFromArray($order){
			$sort = strtoupper(end($order));
			if(!fx_equal($sort,'ASC') && !fx_equal($sort,'DESC')){
				$sort = 'ASC';
			}else{
				unset($order[key($order)]);
			}
			$order = implode(', ', $order);
			return "{$order} {$sort}";
		}

		public function getItemAsArray($result){
			if($result){
				$data = $result->fetch_assoc();
				return $data;
			}
			return array();
		}

		public function getArray($result){
			if($result){
				$data=array();
				while($item = $result->fetch_assoc()){
					$data[] = $item;
				}
				return $data;
			}
			return array();
		}

		public function getItemAsObject($result){
			if($result){
				$data = $result->fetch_object();
				return $data;
			}
			return false;
		}

		public function getObject($result){
			if($result){
				$data=array();
				while($item = $result->fetch_object()){
					$data[] = $item;
				}
				return $data;
			}
			return false;
		}

		public function lastId(){
			return $this->mysqli->insert_id;
		}

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

		public function alter(){

		}

		public function create(){

		}

		public function delete($from_table,$where,$nested_query,$join,$limit,$offset,$order,$group,$preparing){
			$query = 'DELETE ';
			$query .= $this->getTable($from_table);
			$query .= $this->getWhere($where);
			$query .= $this->getNested($nested_query);
			$query .= $this->getUsing($join);
			$query .= $this->getOrder($order);
			$query .= $this->getGroup($group);
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
			$query .= $this->getTableString($table) . " ";
			$query .= $this->getInsertFields();
			$query .= " VALUES \n";
			$query .= $this->getInsertValues();

			if($this->update_insert_string){
				$query .= " \nON DUPLICATE KEY UPDATE ";
				$query .= trim($this->update_insert_string,", \n");
			}
			$query .= ';';

			$result = $this->exec($query,$preparing);
			if($result){
				return $this->lastId();
			}
			return null;
		}

		public function select($fields,$from_table,$where,$nested_query,$join,$limit,$offset,$order,$group,$preparing){
			$query = 'SELECT ';
			$query .= $this->getFields($fields);
			$query .= $this->getTable($from_table);
			$query .= $this->getWhere($where);
			$query .= $this->getNested($nested_query);
			$query .= $this->getJoin($join);
			$query .= $this->getOrder($order);
			$query .= $this->getGroup($group);
			$query .= $this->getLimit($limit);
			$query .= $this->getOffset($offset);

			return $this->exec(trim($query) . ";",$preparing);
		}

		public function update($fields,$table,$where,$nested_query,$join,$limit,$offset,$preparing){
			$this->removeProps();

			$this->getUpdateStringForInsert($fields);
			$this->getUpdateNestedStringForInsert($nested_query);

			$query = "UPDATE ";
			$query .= $this->getTableString($table) . " ";
			$query .= $this->getJoin($join);
			$query .= "SET \n";
			$query .= trim($this->update_insert_string, ", \n");
			$query .= " \n";
			$query .= $this->getWhere($where);
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
				$result .= "(" . implode(', ', $value) . "),\n";
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













	}














