<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertFirstItemToBlogTable202008050937301596659850{

		private $item_id;

		public function addItem(){
			$this->item_id = Database::insert('blog')
				->value('b_user_id',1)
				->value('b_total_views',0)
				->value('b_image_preview_id',1)
				->value('b_title','My first blog post')
				->value('b_slug','1_my_first_blog_post')
				->value('b_status',Kernel::STATUS_ACTIVE)
				->value('b_category_id','1')
				->value('b_content','this is first blogs post item. over.')
				->value('b_date_created',1596654665)
				->get()
				->id();
			return $this;
		}











	}