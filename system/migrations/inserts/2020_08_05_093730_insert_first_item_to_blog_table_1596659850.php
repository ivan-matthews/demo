<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertFirstItemToBlogTable202008050937301596659850{

		private $item_id;

		private $title = '"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."
"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."';

		private $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consectetur odio nec placerat accumsan. Morbi pretium eget tortor at rutrum. Nullam eu commodo urna, vel congue velit. Duis a eros cursus, posuere ipsum sed, feugiat turpis. Phasellus non nulla nec nibh aliquam consequat pretium sed turpis. Fusce commodo nisl vitae felis sollicitudin iaculis. Morbi sed semper sem, at vulputate erat. Proin ut nibh in turpis tincidunt porta.
In hac habitasse platea dictumst. Aliquam at accumsan sem. Nam fermentum massa in malesuada tempor. Maecenas cursus augue augue, a commodo lacus viverra eu. Quisque ante eros, fermentum laoreet augue sed, scelerisque maximus arcu. Morbi fermentum tellus et felis tempus malesuada. Aenean lobortis ligula quis imperdiet ullamcorper.
Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis placerat urna at cursus ultrices. In cursus malesuada eros, a eleifend arcu iaculis quis. Integer risus magna, pharetra sed quam imperdiet, tempor ultricies justo. Donec tellus dui, accumsan eget elementum in, gravida eget orci. Praesent finibus lorem ut tellus efficitur, at pharetra lorem maximus. Sed rutrum id augue ut varius. Donec sed tortor eu metus volutpat accumsan. Nam sollicitudin mi enim, sed sollicitudin turpis laoreet eget. Curabitur elit diam, aliquam vitae sapien in, placerat ullamcorper turpis. Nam sed lorem elit. Aenean quis hendrerit elit, convallis interdum tellus. Aliquam erat volutpat. Proin tincidunt sem est, eu bibendum elit commodo ut. Praesent fringilla dignissim magna, in interdum mi vehicula varius.
Nunc vel nisl et tellus convallis ornare eget eu velit. Sed semper nibh molestie neque malesuada, id elementum dolor pellentesque. Curabitur egestas tristique dui. Mauris scelerisque tempus turpis vel elementum. Maecenas eu hendrerit tellus, eget sodales arcu. Sed commodo vehicula lorem vitae posuere. Integer pharetra leo diam, aliquam congue diam consectetur ut. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean varius quis justo et dictum. Duis felis tellus, aliquet et posuere ut, congue suscipit nisi. Cras non sem id leo suscipit luctus. Praesent ut quam lobortis, euismod urna ut, blandit lorem. Aliquam erat volutpat. Aliquam id mauris nunc. Nunc commodo elementum mi nec maximus.
Aenean id odio sed purus sagittis sollicitudin. Nam ut turpis in odio molestie sollicitudin accumsan a sem. Nam maximus ultricies turpis, vel rutrum lectus pretium in. Quisque elementum justo vel mi porta fermentum. Maecenas dictum sit amet enim ut efficitur. Integer eu ante non magna cursus mollis. Sed eget consequat ex. Suspendisse quis tortor non lorem rutrum vestibulum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin eros dolor, elementum vitae varius et, laoreet non felis. Fusce dignissim pulvinar risus id viverra. Nam ut purus tristique, volutpat nisl gravida, volutpat velit. Phasellus enim eros, venenatis a leo eu, eleifend eleifend nulla. Nulla congue tortor non lobortis tincidunt. Donec ultricies porta nisi, vel porta nibh lacinia in. Aenean a quam enim.
Phasellus vitae blandit ex. Proin nec mollis lacus. Nulla lobortis sapien elit, at semper purus mattis eu. Pellentesque a turpis leo. Vivamus sed lacus aliquet, mollis mauris sed, tincidunt dui. Etiam sem velit, commodo eget gravida vitae, consectetur vel purus. Praesent a ultrices ex.
Aliquam et est eu tellus semper gravida ac vitae erat. Nullam feugiat sodales scelerisque. Etiam ut ligula convallis, scelerisque lacus ut, sollicitudin purus. Etiam finibus consectetur sapien in faucibus. Praesent posuere mi sed elit pharetra congue. Vivamus auctor tortor id orci aliquet, nec bibendum metus pellentesque. Fusce dapibus tincidunt vulputate. Proin quis accumsan sapien, ac cursus sem. Sed efficitur arcu eu tempus scelerisque. Mauris pharetra efficitur nibh eget semper. Nam hendrerit neque ante, sed facilisis sem placerat vel. Morbi placerat, odio nec mattis imperdiet, nunc tellus mollis risus, at dignissim lorem ex id lorem. Mauris in pretium massa. Phasellus quis metus vel ante eleifend fermentum.
Suspendisse ac lobortis justo. Sed elementum orci pellentesque eros dapibus, at varius nulla euismod. Morbi vel fermentum odio, id ultricies sem. Etiam sodales neque id risus feugiat imperdiet. Ut tincidunt ligula et fermentum pulvinar. Aenean nec velit a arcu condimentum rhoncus. Mauris a orci ut ligula vehicula finibus a in tellus. Morbi facilisis felis quis iaculis placerat. Quisque vitae dolor eu tortor sagittis volutpat in ut tortor. Aliquam commodo aliquet tristique. Phasellus lacinia turpis vel elit suscipit, non imperdiet odio dapibus. Nunc non mi sit amet dui porttitor laoreet in id enim. Cras porta eget tellus nec pretium. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas rutrum, lectus et mollis ornare, neque tortor lacinia sem, sodales volutpat neque urna ac mi. Aenean bibendum sapien eu ipsum rhoncus finibus.
Integer lorem eros, finibus finibus feugiat a, iaculis sit amet dolor. Cras nec ligula vel augue pulvinar feugiat. Nullam porttitor, odio sed lobortis pulvinar, nunc lectus tincidunt nulla, in euismod ante enim eu massa. Vivamus efficitur vulputate vehicula. Morbi placerat quis arcu hendrerit dapibus. Fusce in mollis sem. Sed et diam dolor. Curabitur ut tellus sit amet lorem dictum pulvinar ac ut magna. Ut tristique pulvinar neque ut blandit. Mauris dictum ante nec mi convallis euismod. Mauris eget aliquam turpis. Quisque volutpat finibus eleifend.
In dictum, tellus at varius semper, ipsum risus malesuada purus, eu fringilla mi arcu eu augue. Maecenas rutrum ultricies nulla ac sollicitudin. Sed a accumsan mauris. Cras vulputate, magna ut malesuada cursus, leo neque vehicula nisl, sed finibus justo orci et elit. Maecenas ultrices sapien nunc, nec vestibulum lorem porttitor facilisis. Morbi porttitor elementum leo. Etiam et feugiat risus. Aenean sit amet laoreet ante. Donec pharetra ac nulla in tempor. Aliquam erat volutpat. Quisque sed nisi hendrerit, molestie nunc lacinia, fermentum lacus. Quisque sed orci et erat pharetra sollicitudin sit amet in nisl. Integer pulvinar rutrum odio quis euismod. Aliquam dictum malesuada tempus. Sed mattis, ante et interdum auctor, ligula orci interdum orci, a maximus ante turpis a elit.';

		public function addItem(){
			$this->item_id = Database::insert('blog')
				->value('b_user_id',1)
				->value('b_total_views',0)
				->value('b_image_preview_id',1)
				->value('b_slug','1_my_first_blog_post')
				->value('b_status',Kernel::STATUS_ACTIVE)
				->value('b_category_id','1')
				->value('b_title',fx_crop_string($this->title,191,null))
				->value('b_content',$this->content)
				->value('b_date_created',time())
				->get()
				->id();
			return $this;
		}

		public function addItemWithoutImage(){
			$this->item_id = Database::insert('blog')
				->value('b_user_id',1)
				->value('b_total_views',0)
				->value('b_slug','2_my_second_blog_post')
				->value('b_status',Kernel::STATUS_ACTIVE)
				->value('b_category_id','1')
				->value('b_title',fx_crop_string($this->title,191,null))
				->value('b_content',$this->content)
				->value('b_date_created',time())
				->get()
				->id();
			return $this;
		}

		private function addBlogItemsToCategories(){
			$db = Database::insert('blog');
			for($i=0;$i<50;$i++){
				$db = $db->value('b_user_id',rand(1,20));
				$db = $db->value('b_total_views',0);
				$db = $db->value('b_slug',($i+3) . '_my_second_blog_post');
				$db = $db->value('b_status',Kernel::STATUS_ACTIVE);
				$db = $db->value('b_category_id',rand(1,10));
				$db = $db->value('b_title',fx_crop_string($this->title,191,null));
				$db = $db->value('b_content',$this->content);
				$db = $db->value('b_date_created',time());
			}
			$db->get()->id();
			return $this;
		}











	}