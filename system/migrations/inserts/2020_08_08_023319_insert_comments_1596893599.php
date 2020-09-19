<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;

	class InsertComments202008080233191596893599{

		public $items_id = array(
			1 => 0,
			2 => 0
		);

		public $demo_data_string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
		public $demo_data_array = array();

		public function firstStep(){
			$this->getDemoDataArray();

			$insert = Database::insert('comments');
			for($i=1;$i<101;$i++){
				$item_id 		= rand(1,2);
				$author_id 		= rand(1,15);
				$receiver_id 	= rand(1,15);

				$massive[$item_id][$author_id][] = $i;

				$insert = $insert->value('c_author_id',$author_id);
				$insert = $insert->value('c_controller','blog');
				$insert = $insert->value('c_action','item');
				$insert = $insert->value('c_item_id',$item_id);
				$insert = $insert->value('c_content',str_repeat($this->demo_data_array[rand(0,7)],rand(1,10)));
				$insert = $insert->value('c_date_created',time());

				if(isset($massive[$item_id][$receiver_id]) && !fx_equal($author_id,$receiver_id)){
					$insert = $insert->value('c_receiver_id',$receiver_id);		//
					$insert = $insert->value('c_parent_id',$massive[$item_id][$receiver_id][rand(0,max(array_keys($massive[$item_id][$receiver_id])))]);
				}else{
					$insert = $insert->value('c_receiver_id',null);		//
					$insert = $insert->value('c_parent_id',null);
				}
				$this->items_id[$item_id]++;
			}
			$insert->get()->id();
			return $this->updateCommentsCountInBlogItem();
		}

		private function getDemoDataArray(){
			$this->demo_data_array = preg_split("#[^a-z +]{1,3}#si",$this->demo_data_string);
			return $this;
		}

		private function updateCommentsCountInBlogItem(){
			foreach($this->items_id as $key=>$value){
				Database::update('blog')
					->field('b_total_comments',$value)
					->where("`b_id`={$key}")
					->get()
					->rows();
			}
			return $this;
		}

		private function getId($iterator){
			if(!is_int($iterator/2)){
				return null;
			}
			return true;
		}









	}