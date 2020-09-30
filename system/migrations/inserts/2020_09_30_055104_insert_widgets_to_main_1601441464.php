<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Controllers\Blog\Widgets\Blog_Posts as BlogWidget;
	use Core\Controllers\Audios\Widgets\Audios as AudiosWidget;
	use Core\Controllers\Videos\Widgets\Videos as VideosWidget;
	use Core\Controllers\Photos\Widgets\Photos as PhotosWidget;
	use Core\Controllers\Files\Widgets\Files as FilesWidget;
	use Core\Controllers\Comments\Widgets\Comments_Widget as CommentsWidget;
	use Core\Controllers\Users\Widgets\New_Users as NewUsersWidget;
	use Core\Controllers\Users\Widgets\Online_Users as OnlineUsersWidget;

	class InsertWidgetsToMain202009300551041601441464{

		private $blog_widget_id;
		private $audios_widget_id;
		private $videos_widget_id;
		private $photos_widget_id;
		private $files_widget_id;
		private $comments_widget_id;
		private $new_users_widget_id;
		private $online_users_widget_id;

		public function addBlogWidget(){
			$this->blog_widget_id = Database::insert('widgets')
				->value('w_class',BlogWidget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/blog/widgets/blog_posts')
				->get()
				->id();
			return $this;
		}

		public function addAudiosWidget(){
			$this->audios_widget_id = Database::insert('widgets')
				->value('w_class',AudiosWidget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/audios/widgets/audios')
				->get()
				->id();
			return $this;
		}

		public function addVideosWidget(){
			$this->videos_widget_id = Database::insert('widgets')
				->value('w_class',VideosWidget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/videos/widgets/videos')
				->get()
				->id();
			return $this;
		}

		public function addPhotosWidget(){
			$this->photos_widget_id = Database::insert('widgets')
				->value('w_class',PhotosWidget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/photos/widgets/photos')
				->get()
				->id();
			return $this;
		}

		public function addFilesWidget(){
			$this->files_widget_id = Database::insert('widgets')
				->value('w_class',FilesWidget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/files/widgets/files')
				->get()
				->id();
			return $this;
		}

		public function addCommentsWidget(){
			$this->comments_widget_id = Database::insert('widgets')
				->value('w_class',CommentsWidget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/comments/widgets/comments')
				->get()
				->id();
			return $this;
		}

		public function addNewUsersWidget(){
			$this->new_users_widget_id = Database::insert('widgets')
				->value('w_class',NewUsersWidget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/users/widgets/new_users')
				->get()
				->id();
			return $this;
		}

		public function addOnlineUsersWidget(){
			$this->online_users_widget_id = Database::insert('widgets')
				->value('w_class',OnlineUsersWidget::class)
				->value('w_method','run')
				->value('w_status',Kernel::STATUS_ACTIVE)
				->value('w_template','controllers/users/widgets/online_users')
				->get()
				->id();
			return $this;
		}

		public function addActiveBlogWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->blog_widget_id)
				->value('wa_name','blog_before_content')
				->value('wa_title','blog.blog_before_content_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','before_content')
				->value('wa_ordering',3)
				->value('wa_pages_enabled',array('home'=>array('index')))
				->value('wa_template','controllers/blog/widgets/blog_posts')
				->get()
				->id();
			return $this;
		}

		public function addActiveAudiosWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->audios_widget_id)
				->value('wa_name','audios_before_content')
				->value('wa_title','audios.audios_before_content_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','before_content')
				->value('wa_ordering',6)
				->value('wa_pages_enabled',array('home'=>array('index')))
				->value('wa_template','controllers/audios/widgets/audios')
				->get()
				->id();
			return $this;
		}

		public function addActiveVideosWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->videos_widget_id)
				->value('wa_name','videos_before_content')
				->value('wa_title','videos.videos_before_content_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','before_content')
				->value('wa_ordering',5)
				->value('wa_pages_enabled',array('home'=>array('index')))
				->value('wa_template','controllers/videos/widgets/videos')
				->get()
				->id();
			return $this;
		}

		public function addActivePhotosWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->photos_widget_id)
				->value('wa_name','photos_before_content')
				->value('wa_title','photos.photos_before_content_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','before_content')
				->value('wa_ordering',4)
				->value('wa_pages_enabled',array('home'=>array('index')))
				->value('wa_template','controllers/photos/widgets/photos')
				->get()
				->id();
			return $this;
		}

		public function addActiveFilesWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->files_widget_id)
				->value('wa_name','files_before_content')
				->value('wa_title','files.files_before_content_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','before_content')
				->value('wa_ordering',7)
				->value('wa_pages_enabled',array('home'=>array('index')))
				->value('wa_template','controllers/files/widgets/files')
				->get()
				->id();
			return $this;
		}

		public function addActiveCommentsWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->comments_widget_id)
				->value('wa_name','comments_before_content')
				->value('wa_title','comments.comments_before_content_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','before_content')
				->value('wa_ordering',8)
				->value('wa_pages_enabled',array('home'=>array('index')))
				->value('wa_template','controllers/comments/widgets/comments')
				->get()
				->id();
			return $this;
		}

		public function addActiveNewUsersWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->new_users_widget_id)
				->value('wa_name','new_users_before_content')
				->value('wa_title','users.new_users_before_content_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','before_content')
				->value('wa_ordering',2)
				->value('wa_pages_enabled',array('home'=>array('index')))
				->value('wa_template','controllers/users/widgets/new_users')
				->get()
				->id();
			return $this;
		}

		public function addActiveOnlineUsersWidget(){
			Database::insert('widgets_active')
				->value('wa_widget_id',$this->online_users_widget_id)
				->value('wa_name','online_users_before_content')
				->value('wa_title','users.online_users_before_content_widget_title')
				->value('wa_css_class','')
				->value('wa_css_class_title','')
				->value('wa_css_class_body','')
				->value('wa_show_title',1)
				->value('wa_unite_prev',0)
				->value('wa_status',Kernel::STATUS_ACTIVE)
				->value('wa_position','before_content')
				->value('wa_ordering',1)
				->value('wa_pages_enabled',array('home'=>array('index')))
				->value('wa_template','controllers/users/widgets/online_users')
				->get()
				->id();
			return $this;
		}











	}