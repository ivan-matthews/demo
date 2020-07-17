<?php

	namespace Core\Database\Interfaces\Alter;

	interface Indexes{
		public function addIndex($index=false);
		public function addPrimary($index=false);
		public function addFulltext($index=false);
		public function addUnique($index=false);
		public function dropFulltext($index=false);
		public function dropIndex($index=false);
		public function dropPrimary($index=false);
		public function dropUnique($index=false);
	}