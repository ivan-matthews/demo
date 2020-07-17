<?php

	#CMD: php cli make test [first_argument second_argument]
	#DSC: call testing command
	#EXM: php cli make test one two

	namespace System\Console\Make;

	class Test{

		public function __construct(){
			print __METHOD__ . PHP_EOL;
		}

		public function execute($first_argument,$second_argument){
			print $first_argument . PHP_EOL;
			print $second_argument . PHP_EOL;
		}

	}