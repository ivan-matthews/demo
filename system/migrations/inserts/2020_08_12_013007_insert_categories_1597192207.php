<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;

	class InsertCategories202008120130071597192207{

		private $categories = array(
			array(
				'ct_name'			=> 'news',
				'ct_controller'		=> 'blog',
				'ct_title'			=> 'cats.blog_news_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'word',
				'ct_controller'		=> 'blog',
				'ct_title'			=> 'cats.blog_word_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'cook',
				'ct_controller'		=> 'blog',
				'ct_title'			=> 'cats.blog_cook_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'game',
				'ct_controller'		=> 'blog',
				'ct_title'			=> 'cats.blog_game_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'hobby',
				'ct_controller'		=> 'blog',
				'ct_title'			=> 'cats.blog_hobby_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'pages_news',
				'ct_controller'		=> 'pages',
				'ct_title'			=> 'cats.blog_news_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'articles_word',
				'ct_controller'		=> 'articles',
				'ct_title'			=> 'cats.blog_word_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'faq_cook',
				'ct_controller'		=> 'faq',
				'ct_title'			=> 'cats.blog_cook_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'news_game',
				'ct_controller'		=> 'news',
				'ct_title'			=> 'cats.blog_game_title',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
			array(
				'ct_name'			=> 'blog_hobby',
				'ct_controller'		=> 'blog',
				'ct_title'			=> 'cats.blog_hobby_title_alt',
				'ct_icon'			=> "fa fa-list",
				'ct_description'	=> NULL,
			),
		);

		public function firstStep(){
			$current_time = time();
			$db = Database::insert('categories');
			foreach($this->categories as $category){
				$db = $db->value('ct_name',$category['ct_name']);
				$db = $db->value('ct_controller',$category['ct_controller']);
				$db = $db->value('ct_title',$category['ct_title']);
				$db = $db->value('ct_icon',$category['ct_icon']);
				$db = $db->value('ct_description',$category['ct_description']);
				$db = $db->value('ct_date_created',$current_time);
			}
			$db->get()->id();
			return $this;
		}










	}