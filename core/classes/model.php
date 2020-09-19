<?php
	/*
		use Core\Classes\Database\Interfaces\Create\Create;
		\Core\Classes\_Model::getInstance()->makeTable('tablitsa',function(Create $c){
			$c->varchar('ds')->nullable()->index();
		});
	 */

	namespace Core\Classes;

	use Core\Classes\Database\Database;
	use Core\Classes\Cache\Cache;
	use Core\Classes\Database\Interfaces\Query\Query;
	use Core\Classes\Database\Interfaces\Delete\Delete;
	use Core\Classes\Database\Interfaces\Insert\Insert;
	use Core\Classes\Database\Interfaces\Select\Select;
	use Core\Classes\Database\Interfaces\Update\Update;
	use Core\Classes\Database\Connect\MySQL;

	/**
	 * Class Model
	 * @package Core\Classes
	 * @method Select select(...$fields)
	 * @method Update update($in_table)
	 * @method Insert insert($to_table)
	 * @method Delete delete(...$from_tables)
	 * @method Query query($query)
	 * @method bool alterTable($table, callable $callback_function)
	 * @method bool makeTable($table, callable $callback_function)
	 * @method array showIndex($table)
	 * @method bool dropTable(...$tables)
	 * @method bool truncate(...$tables)
	 * @method array showTables($database=false)
	 * @method array showDBs()
	 * @method MySQL useDb($database)
	 * @method bool dropDb($database_name)
	 * @method bool makeDb($new_database_name)
	 * @method Database setCollate($collate)
	 * @method Database setCharset($charset)
	 * @method Database setDbDriver($driver)
	 * @method MySQL setDbObject()
	 * @method string getDbDriver()
	 * @method MySQL getDbObject()
	 */
	class Model{

		private static $instance;

		protected $database;
		protected $cache;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->database = Database::getInstance();
			$this->cache = Cache::getInstance();
		}

		public function __call($function_name,array $argument_list){
			if(method_exists($this->database,$function_name)){
				return call_user_func(array($this->database,$function_name),...$argument_list);
			}
			return null;
		}



















	}














