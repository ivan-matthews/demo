<?php

	namespace System\Migrations;

	use Core\Classes\Database;
//	use Core\Database\Alter;
	use Core\Database\Interfaces\Alter\Alter;

	class __class_name__{

		public function firstStep(){

			return $this;
		}

		public function secondStep(){
			Database::alterTable('__table_name__',function(Alter $table){
				/*
					$table->field('a')->addColumn()->bigint()->unsigned()->notNull();
					$table->field('a')->modifyColumn()->varchar(121);
					$table->field('a')->changeColumn('new_a')->bigint()->unsigned()->notNull();
					$table->field('new_a')->dropColumn();
					$table->field('id')->dropAutoIncrement()->varchar(191)->notNull();
					$table->field('id')->addAutoIncrement()->bigint(11)->notNull();
					$table->field('s')->addColumn()->bigint()->unsigned()->notNull()->addIndex();
					$table->field('t')->addColumn()->bigint()->unsigned()->notNull()->addPrimary();
					$table->field('g')->addColumn()->bigint()->unsigned()->notNull()->addFulltext();
					$table->field('h')->addColumn()->bigint()->unsigned()->notNull()->addUnique();
					$table->field('q')->addColumn()->bigint()->unsigned()->notNull()->dropIndex();
					$table->field('w')->addColumn()->bigint()->unsigned()->notNull()->dropFulltext();
					$table->field('e')->addColumn()->bigint()->unsigned()->notNull()->dropPrimary();
					$table->field('r')->addColumn()->bigint()->unsigned()->notNull()->dropUnique();

					$table->exec();
				*/
			});
			return $this;
		}











	}