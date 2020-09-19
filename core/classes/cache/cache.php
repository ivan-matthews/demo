<?php

	namespace Core\Classes\Cache;

	use Core\Classes\Config;

	/**
	 * Class Cache
	 * @package Core\Classes\Cache
	 * @method static Cache _get()
	 * @method static Cache _set($data)
	 * @method static Cache _clear()
	 * @method static Cache _object()
	 * @method static Cache _array()
	 * @method static Cache _key($key=null)
	 * @method static Cache _index($index)
	 * @method static Cache _ttl($ttl)
	 * @method static Cache _drop()
	 * @method static Cache _mark($mark)
	 */
	class Cache{

		const DEFAULT_INDEX = 4;

		private static $instance;

		private $data_result = array();

		private $driver_key;
		private $params;
		private $config;
		/** @var PHP|JSON|Mongo|Memcached */
		private $driver_object;

		public static function __callStatic($method,$arguments){
			$method = trim($method,'_');
			$self_object = self::getInstance();
			if(method_exists($self_object,$method)){
				return call_user_func(array($self_object,$method),...$arguments);
			}
			return $self_object;
		}

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->params = $this->config->cache;
			$this->params['site_host'] = $this->config->core['site_host'];
			$this->params['index'] = self::DEFAULT_INDEX;
			$this->driver_key = $this->params['cache_driver'];
			$this->setCacheDriverObject();
		}

		/**
		 * <h3>Получить ранее сохраненные данные из кэша</h3>
		 *
		 * @return object $this
		 */
		public function get(){
			if(!$this->params['cache_enabled']){ return $this; }
			$this->data_result = $this->driver_object->get();
			return $this;
		}

		/**
		 * <h3>Сохранить данные в кэш для дальнейшего пользования</h3>
		 *
		 * @param $data
		 * @return bool|$this
		 */
		public function set($data){
			if(!$this->params['cache_enabled']){ return $this; }
			$data = fx_arr($data);
			$this->driver_object->set($data);
			return $this;
		}

		/**
		 * <h3>Очистить все ранее закэшированные данные<br>
		 * Уровень вложенности ключа, установленного<br>
		 * ранее с помощью метода Cache::key($key_address)<br>
		 * покажет с какой отметки надо удалять ключи<br></h3>
		 *
		 * @return bool
		 */
		public function clear(){
			return $this->driver_object->clear();
		}

		/**
		 * <h3>Получить кэшированные данные в виде объекта<br>
		 *
		 * @return object|boolean
		 */
		public function object(){
			return json_decode(json_encode($this->data_result));
		}

		/**
		 * <h3>Получить кэшированные данные в виде массива<br>
		 *
		 * @return array|boolean
		 */
		public function array(){
			return $this->data_result;
		}

		/**
		 * <h3>Установить ключ кэша<br>
		 * Ключом кэша будет считаться его физический адрес<br>
		 * с помощью которого, по-необходимости, его можно будет<br>
		 * уничтожить вдальнейшем</h3>
		 *
		 * @param null $key
		 * @return $this
		 */
		public function key($key=null){
			$this->driver_object->key($key);
			return $this;
		}

		/**
		 * <h3>Установить индекс генерации метки ключа<br>
		 * (бесполезно, если метка задана вручную <br>
		 * с помощью метода Cache::mark($mark_name))<br></h3>
		 *
		 * @param $index
		 * @return $this
		 */
		public function index($index){
			$this->driver_object->index($index);
			return $this;
		}

		/**
		 * <h3>Задать вручную срок годности кэша<br>
		 * По истечении времени, данные перезапишутся<br></h3>
		 *
		 * @param $ttl
		 * @return $this
		 */
		public function ttl($ttl){
			$this->driver_object->ttl($ttl);
			return $this;
		}

		private function setCacheDriverObject(){
			$class = "\\Core\\Classes\\Cache\\{$this->driver_key}";
			$this->driver_object = new $class($this->params);
			return $this;
		}

		/**
		 * <h3>Сброс всех предопределенных свойств<br>
		 * объекта Cache::$driver_object,<br>
		 * в первую очередь Cache::$mark_sending,<br>
		 * если метка ключа была задана вручную<br></h3>
		 *
		 * @return $this
		 */
		public function drop(){
			$this->driver_object->drop();
			return $this;
		}

		/**
		 * <h3>Задать метку ключа вручную<br>
		 * По-умолчанию: метка генерируется из стека<br>
		 * функции debug_backtrace()<br>
		 * (для сброса - метод Cache::drop())<br></h3>
		 *
		 * @param $mark
		 * @return $this
		 */
		public function mark($mark){
			$this->driver_object->mark($mark);
			return $this;
		}
























	}














