<?php

	namespace Core\Controllers\News\Cron;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;
	use Core\Controllers\News\Controller;
	use phpQuery;
	use Core\Classes\Jevix;

	class Parse_Gazeta_Ua{

		public $params;
		public $limit = 10;

		public function __construct(){

		}

		/**
		 * @param $params 'cron_task' item array from DB
		 * @return string | boolean
		 */
		public function execute($params){
			$this->params = $params;

			fx_load_helper('core/helpers/libraries/phpQuery-onefile',Kernel::IMPORT_INCLUDE_ONCE);

			$this->runParser();

			return $this->result;
		}

		public function runParser(){
			$xml = simplexml_load_file('https://gazeta.ua/ru/rss');

			$content = array();

			$index = 0;

			$copy['image'] = trim($xml->channel->image->url);
			$copy['link'] = trim($xml->channel->image->link);
			$copy['title'] = trim($xml->channel->image->title);

			$copyright = "<p style=\"float:right\"><a target=\"_blank\" href=\"{$copy['link']}\" alt=\"{$copy['title']}\" title=\"{$copy['title']}\"><img  style=\"width:75px\" src=\"{$copy['image']}\"/></a></p>";
	
			foreach($xml->channel->item as $item){
				if($this->limit <= $index){ break; }
				if(!$item->enclosure){ continue; }
				if(!$item->category){ continue; }

				$content['nw_content'] 		= $this->getContent(trim($item->link));
				if(!$content['nw_content']){ continue; }
				
				$post_hash = md5(trim($item->link));

				if($this->checkExistsPost($post_hash)){ continue; }

				$user = $this->getUserID();

				$link = $item->enclosure->attributes();

				$content['nw_user_id'] 		= $user;
				$content['nw_title'] 		= trim($item->title);
				$content['nw_hash'] 		= $post_hash;
				$content['nw_date_created']	= strtotime($item->pubDate);
				$content['nw_date_updated']	= time();
				$content['nw_content'] 		= $this->getContent(trim($item->link)) . $copyright;
				$content['nw_category_id'] 	= $item->category ? $this->getOrAddCategoryID(trim($item->category)) : null;
				$content['nw_image_preview_id'] = $link->url ? $this->getOrAddPhotoID($user,trim($link->url)) : null;
				$content['nw_status'] 			= true;
				$content['nw_comments_enabled'] = true;
				$content['nw_public'] 			= true;

				$post_id = $this->addPost($content);
				$this->updatePost($post_id,trim($item->title));
				$index++;
			}
			return $this;
		}

		public function checkExistsPost($post_hash){
			$post = Database::select('nw_id')
				->from('news')
				->where("nw_hash = '{$post_hash}'")
				->get()
				->itemAsArray();
			if($post){
				return true;
			}
			return false;
		}

		public function getOrAddCategoryID($category){
			$ct_name = fx_create_slug_from_string($category);
			$category_in_DB = Database::select('ct_id')
				->from('categories')
				->where("ct_name='news_{$ct_name}'")
				->get()
				->itemAsArray();
			if($category_in_DB){
				return $category_in_DB['ct_id'];
			}

			$item['ct_name'] 		= "news_{$ct_name}";
			$item['ct_controller']	= 'news';
			$item['ct_title']		= $category;
			$item['ct_date_created'] = time();

			return Database::insert('categories')
				->value('ct_name',$item['ct_name'])
				->value('ct_controller',$item['ct_controller'])
				->value('ct_title',$item['ct_title'])
				->value('ct_date_created',$item['ct_date_created'])
				->update('ct_title',$item['ct_title'])
				->get()->id();
		}

		public function getOrAddPhotoID($user_id,$photo){
			$image_hash = md5($photo);
			$image = Database::select('p_id')
				->from('photos')
				->where("p_hash='{$user_id}-{$image_hash}'")
				->get()
				->itemAsArray();
			if($image){
				return $image['p_id'];
			}
			
			$photo_name = basename(parse_url($photo,PHP_URL_PATH));
			
			return Database::insert('photos')
				->value('p_user_id',$user_id)
				->value('p_external',true)
				->value('p_name',$photo_name)
				->value('p_size',0)
				->value('p_micro',$photo)
				->value('p_small',$photo)
				->value('p_medium',$photo)
				->value('p_normal',$photo)
				->value('p_big',$photo)
				->value('p_poster',$photo)
				->value('p_original',$photo)
				->value('p_hash',"{$user_id}-{$image_hash}")
				->value('p_mime','image/jpeg')
				->value('p_status',Kernel::STATUS_ACTIVE)
				->value('p_date_created',time())
				->update('p_name',$photo_name)
				->get()
				->id();
		}
		public function addPost($post_content){
			$post_id = Database::insert('news');
			foreach($post_content as $field => $value){
				$post_id = $post_id->value($field, $value);
			}
			$post_id = $post_id->get()->id();
			return $post_id;
		}
		public function updatePost($post_id,$post_slug){
			$news_controller = new Controller();

			return Database::update('news')
				->field('nw_slug',$news_controller->makeSlugFromString($post_id,$post_slug))
				->where("nw_id = '{$post_id}'")
				->get()
				->rows();
		}

		public function getUserID(){
			$user = Database::select('u_id')
				->from('users')
				->where("`u_user_type`='2'")
				->order('RAND()')
				->sort('ASC')
				->limit(1)
				->get()->itemAsArray();
			return $user['u_id'];
		}

		public function getContent($link_content){
			$link_content = file_get_contents($link_content);

			$link_content = preg_replace("#\<strong\>ЧИТАЙТЕ ТАКЖЕ\:(.*?)\<\/strong\>#si",'',$link_content);

			$pq = phpQuery::newDocument($link_content);
			$elem = $pq->find('section.article-content');
			$text = $elem->html();

			$jevix = new Jevix(array('is_auto_br'=>false,'text'=>$text));
			$jevix->call(function(Jevix $jevix, $tag, $params, $content){
				if(!$content){ return null; }
				if(fx_equal(trim($params['class']),'modal-full-image')){ return null; }
				if(fx_equal(trim($params['class']),'back-block')){ return null; }
				return $content;
			});
			$jevix->start();
			$text = $jevix->result();

			if(preg_match("#[єї]#usi",$text)){
				return null;
			}

			return $text;
		}
















	}














