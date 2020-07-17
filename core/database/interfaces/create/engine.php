<?php

	namespace Core\Database\Interfaces\Create;

	interface Engine{
		/**
		 * @return Engine
		 * @param $charset string
		 * */
		public function tableCharset($charset);
		/**
		 * @return Engine
		 * @param $collate string
		 * */
		public function tableCollate($collate);
	}