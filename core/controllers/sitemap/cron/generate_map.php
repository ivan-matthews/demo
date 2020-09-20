<?php

	namespace Core\Controllers\Sitemap\Cron;

	use Core\Classes\Config;
	use Core\Classes\Hooks;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Map{

		public $params;

		private $hooks;
		private $config;
		private $debug;
		private $controller;

		public $last_mod_date;
		public $root_path;
		public $path;

		public $root_sitemap_files = array();

		public function __construct(){
			$this->config = Config::getInstance();
			$this->controller = Controller::getInstance();

			$this->last_mod_date = date('c');

			$this->path = $this->controller->params->site_map_root_path;
			$this->root_path = fx_path($this->path);

			$this->debug = $this->config->core['debug_enabled'];
			$this->config->set(false,'core','debug_enabled');

			$this->hooks = Hooks::getInstance();
			$this->hooks->before('sitemap_generate');
		}

		public function __destruct(){
			$this->hooks->after('sitemap_generate');
			$this->config->set($this->debug,'core','debug_enabled');
		}

		/**
		 * @param $params 'cron_task' item array from DB
		 * @return string | boolean
		 */
		public function execute($params){
			$this->params = $params;

			$this->hooks->run('sitemap_generate');

			$this->makeRootXMLFile();

			return true;
		}

		public function makeRootXMLFile(){
			foreach(scandir($this->root_path) as $item){
				if($item == '.' || $item == '..'){ continue; }
				if(is_dir("{$this->root_path}/{$item}")){
					$this->makeChildrenXMLFiles($item);
				}
			}
			if($this->root_sitemap_files){
				return $this->makeXMLContent($this->root_sitemap_files,"{$this->root_path}/sitemap.xml");
			}
			return $this;
		}

		public function makeChildrenXMLFiles($item){
			$files = glob("{$this->root_path}/{$item}/sitemap_*.xml");
			if($files){
				sort($files,SORT_NATURAL);
				$content = array();
				foreach($files as $file){
					$content[] = array(
						'loc'		=> "{$this->controller->site_link}" . str_replace(ROOT,'',$file),
						'lastmod'	=> $this->last_mod_date,
					);
				}
				$this->makeXMLContent($content,"{$this->root_path}/{$item}/sitemap.xml");

			}

			$this->root_sitemap_files[] = array(
				'loc'		=> "{$this->controller->site_link}/{$this->path}/{$item}/sitemap.xml",
				'lastmod'	=> $this->last_mod_date
			);

			return $this;
		}

		public function makeXMLContent(array $content,$path_file_to_save){
			$xml_content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" . PHP_EOL;
			$xml_content .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">" . PHP_EOL;
			$xml_content .= fx_xml_encode($content,"   ","","sitemap");
			$xml_content .= "</sitemapindex>";
			return $this->save($path_file_to_save,$xml_content);
		}

		public function save($path_to_save,$content){
			file_put_contents($path_to_save,$content);
			return $this;
		}














	}














