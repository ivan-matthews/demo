<?php

	namespace Core\Classes\Interfaces;

	interface View{
		/**
		 * @param $render_header
		 * @return View
		 */
		public function setRenderType($render_header);

		/**
		 * @return View
		 */
		public function ready();

		/**
		 * @return View
		 */
		public function renderErrorPages();

		/**
		 * @return View
		 */
		public function renderController();

		/**
		 * @param $file_path
		 * @param array $data
		 * @return View
		 */
		public function render($file_path,array $data);

		/**
		 * @param $file_path
		 * @param array $data
		 * @return View
		 */
		public function renderMail($file_path,array $data);
		/**
		 * @return View
		 */
		public function includeHomePage();

		/**
		 * @param $file_path
		 * @param array $data
		 * @return View
		 */
		public function renderAsset($file_path,array $data);

		/**
		 * @param $path
		 * @return View
		 */
		public function path($path);

		/**
		 * @return View
		 */
		public function start();

		/**
		 * @param $js_file_path
		 * @param null $version
		 * @return View
		 */
		public function addJS($js_file_path,$version=true);

		/**
		 * @param $js_file_path
		 * @param null $version
		 * @return View
		 */
		public function appendJS($js_file_path,$version=true);

		/**
		 * @param $js_file_path
		 * @param null $version
		 * @return View
		 */
		public function prependJS($js_file_path,$version=true);

		/**
		 * @param $css_file_path
		 * @param null $version
		 * @return View
		 */
		public function addCSS($css_file_path,$version=true);

		/**
		 * @param $css_file_path
		 * @param null $version
		 * @return View
		 */
		public function appendCSS($css_file_path,$version=true);

		/**
		 * @param $css_file_path
		 * @param null $version
		 * @return View
		 */
		public function prependCSS($css_file_path,$version=true);

		/**
		 * @return View
		 */
		public function renderJsFiles();

		/**
		 * @return View
		 */
		public function renderCssFiles();

		/**
		 * @param null $site_host
		 * @return View
		 */
		public function setSiteHost($site_host = null);

		/**
		 * @return View
		 */
		public function isContent();

		/**
		 * @return View
		 */
		public function printContent();

		/**
		 * @return View
		 */
		public function printTitle();

		/**
		 * @param $upload_pth_to_file
		 * @return string
		 */
		public function getUploadSiteRoot($upload_pth_to_file);
	}