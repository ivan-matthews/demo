<?php

	namespace Core\Classes;
	
	use Core\Helpers\Libraries\Jevix as JevixParent;

	class Jevix extends JevixParent{

		private $build_redirect_link = true;
		private $is_auto_br = true;
		private $input_data;
		private $result_string_data;

		private $config;

		public function __construct($data){
			$this->input_data = $data;
			$this->config = Config::getInstance();
		}

		public function start(){
			$errors = null;
			if(is_array($this->input_data)){
				$text = $this->input_data['text'];
				if(isset($this->input_data['is_auto_br'])){
					$this->is_auto_br = $this->input_data['is_auto_br'];
				}
				if(isset($this->input_data['build_redirect_link'])){
					$this->build_redirect_link = $this->input_data['build_redirect_link'];
				}
			}else{
				$text = $this->input_data;
			}
			$this->result_string_data = $this->getJevix()
				->parse($text, $errors);
			return $this;
		}

		public function result(){
			return $this->result_string_data;
		}

		private function getJevix(){
			// Устанавливаем разрешённые теги. (Все не разрешенные теги считаются запрещенными.)
			$this->cfgAllowTags(array(
				'p', 'br', 'span', 'div',
				'a', 'img', 'input', 'label',
				'b', 'i', 'u', 's', 'del', 'em', 'strong', 'sup', 'sub', 'hr', 'font',
				'ul', 'ol', 'li',
				'table', 'tbody', 'thead', 'tfoot', 'tr', 'td', 'th',
				'h1','h2','h3','h4','h5','h6',
				'pre', 'code', 'blockquote',
				'video', 'source', 'audio', 'youtube', 'facebook', 'figure', 'figcaption',
				'object', 'param', 'embed', 'iframe', 'spoiler'
			));
			// Устанавливаем коротие теги. (не имеющие закрывающего тега)
			$this->cfgSetTagShort(array(
				'br', 'img', 'hr', 'embed', 'input', 'source'
			));
			// Устанавливаем преформатированные теги. (в них все будет заменятся на HTML сущности)
			$this->cfgSetTagPreformatted(array(
				'pre', 'code'
			));
			// Устанавливаем теги, которые необходимо вырезать из текста вместе с контентом.
			$this->cfgSetTagCutWithContent(array(
				'script', 'style', 'meta'
			));
			$this->cfgSetTagIsEmpty(array(
				'param','embed','a','iframe','div'
			));
			// Устанавливаем разрешённые параметры тегов. Также можно устанавливать допустимые значения этих параметров.
			$this->cfgAllowTagParams('a', array('href' => '#link', 'name' => '#text', 'target' => '#text', 'class' => '#text'));
			$this->cfgAllowTagParams('img', array('src', 'style' => '#text', 'alt' => '#text', 'title' => '#text', 'align' => array('right', 'left', 'center'), 'width' => '#int', 'height' => '#int', 'hspace' => '#int', 'vspace' => '#int', 'class' => '#text'));
			$this->cfgAllowTagParams('span', array('style' => '#text'));
			$this->cfgAllowTagParams('input', array('tabindex' => '#text', 'type' => '#text', 'id' => '#text'));
			$this->cfgAllowTagParams('label', array('class' => '#text', 'for' => '#text'));
			$this->cfgAllowTagParams('object', array('width' => '#int', 'height' => '#int', 'data' => array('#domain'=>array('youtube.com','rutube.ru','vimeo.com','vk.com')), 'type' => '#text'));
			$this->cfgAllowTagParams('param', array('name' => '#text', 'value' => '#text'));
			$this->cfgAllowTagParams('embed', array('src' => array('#domain'=>array('youtube.com','rutube.ru','vimeo.com','vk.com')), 'type' => '#text','allowscriptaccess' => '#text', 'allowfullscreen' => '#text','width' => '#int', 'height' => '#int', 'flashvars'=> '#text', 'wmode'=> '#text'));
			$this->cfgAllowTagParams('iframe', array('width' => '#int', 'height' => '#int', 'style' => '#text', 'frameborder' => '#int', 'allowfullscreen' => '#text', 'src' => array('#domain'=>array('youtube.com','rutube.ru','vimeo.com','vk.com','my.mail.ru','facebook.com'))));
			$this->cfgAllowTagParams('table', array('width' => '#int', 'height' => '#int', 'cellpadding' => '#int', 'cellspacing' => '#int', 'border' => '#int', 'style' => '#text', 'align'=>'#text', 'valign'=>'#text'));
			$this->cfgAllowTagParams('td', array('width' => '#int', 'height' => '#int', 'style' => '#text', 'align'=>'#text', 'valign'=>'#text', 'colspan'=>'#int', 'rowspan'=>'#int'));
			$this->cfgAllowTagParams('th', array('width' => '#int', 'height' => '#int', 'style' => '#text', 'align'=>'#text', 'valign'=>'#text', 'colspan'=>'#int', 'rowspan'=>'#int'));
			$this->cfgAllowTagParams('p', array('style' => '#text'));
			$this->cfgAllowTagParams('div', array('style' => '#text', 'class' => '#text'));
			$this->cfgAllowTagParams('spoiler', array('title' => '#text'));
			$this->cfgAllowTagParams('code', array('type' => '#text'));
			$this->cfgAllowTagParams('figure', array('style' => '#text', 'class' => '#text'));
			$this->cfgAllowTagParams('figcaption', array('style' => '#text', 'class' => '#text'));
			$this->cfgAllowTagParams('h2', array('id' => '#text', 'class' => '#text'));
			$this->cfgAllowTagParams('h3', array('id' => '#text', 'class' => '#text'));
			$this->cfgAllowTagParams('h4', array('id' => '#text', 'class' => '#text'));
			$this->cfgAllowTagParams('h5', array('id' => '#text', 'class' => '#text'));
			$this->cfgAllowTagParams('video', array('controls' => '#text', 'class' => '#text', 'width' => '#int', 'height' => '#int'));
			$this->cfgAllowTagParams('source', array('src' => '#text', 'type' => '#text'));
			// Устанавливаем параметры тегов являющиеся обязательными. Без них вырезает тег оставляя содержимое.
			$this->cfgSetTagParamsRequired('img', 'src');
			$this->cfgSetTagParamsRequired('a', 'href');
			// Устанавливаем теги которые может содержать тег контейнер
			$this->cfgSetTagChilds('video',array('source'),false,true);
			$this->cfgSetTagChilds('ul',array('li'),false,true);
			$this->cfgSetTagChilds('ol',array('li'),false,true);
			$this->cfgSetTagChilds('table',array('tr', 'tbody', 'thead', 'tfoot', 'th', 'td'),false,true);
			$this->cfgSetTagChilds('tbody',array('tr', 'td', 'th'),false,true);
			$this->cfgSetTagChilds('thead',array('tr', 'td', 'th'),false,true);
			$this->cfgSetTagChilds('tfoot',array('tr', 'td', 'th'),false,true);
			$this->cfgSetTagChilds('tr',array('td'),false,true);
			$this->cfgSetTagChilds('tr',array('th'),false,true);
			// Устанавливаем автозамену
			$this->cfgSetAutoReplace(array('+/-', '(c)', '(с)', '(r)', '(C)', '(С)', '(R)'), array('±', '©', '©', '®', '©', '©', '®'));
			// включаем режим замены переноса строк на тег <br/>
			$this->cfgSetAutoBrMode($this->is_auto_br);
			// включаем режим автоматического определения ссылок
			$this->cfgSetAutoLinkMode(true);
			// обрабатываем внешние ссылки
			$this->cfgSetTagCallbackFull('a', array($this, 'linkRedirectPrefix'));
			$this->cfgSetTagCallbackFull('img', array($this, 'parseImg'));
			// Отключаем типографирование в определенном теге
			$this->cfgSetTagNoTypography(array('pre', 'youtube', 'iframe', 'code'));
			$this->cfgSetTagNoAutoBr(array('ul','ol','code','video'));
			// Ставим колбэк для youtube
			$this->cfgSetTagCallbackFull('youtube', array($this, 'parseYouTubeVideo'));
			// Ставим колбэк для facebook
			$this->cfgSetTagCallbackFull('facebook', array($this, 'parseFacebookVideo'));
			// Ставим колбэк на iframe
			$this->cfgSetTagCallbackFull('iframe', array($this, 'parseIframe'));
			// Ставим колбэк для кода
//			$this->cfgSetTagCallbackFull('code', array($this, 'parseCode'));
			// Ставим колбэк для спойлеров
			$this->cfgSetTagCallbackFull('spoiler', array($this, 'parseSpoiler'));
			return $this;
		}

		public function linkRedirectPrefix($tag, $params, $content){
			$tag_string = '<a';
			if($this->build_redirect_link){
				$link_params = parse_url($params['href']);
				if(!empty($link_params['host']) && mb_strpos($params['href'],$this->config->core['site_host']) === false){
					$params['class'] = isset($params['class']) ? "{$params['class']} external":"external";
					$params['target'] = '_blank';
					$params['rel']    = 'noopener';
					$params['href'] = fx_get_url('redirect','index') . "?to=" . urlencode($params['href']);
				}
			}
			foreach($params as $param => $value) {
				if ($value != '') {
					$tag_string.=' '.$param.'="'.$value.'"';
				}
			}
			$tag_string .= '>'.$content.'</a>';
			return $tag_string;
		}

		public function parseImg($tag, $params, $content) {
			if(!empty($params['style'])){
				$styles = explode(';', rtrim(trim($params['style']), ';'));
				foreach ($styles as $k => $style) {
					list($css_name, $css_value) = explode(':', $style);
					if(trim($css_name) == 'height'){ unset($styles[$k]); }
				}
				$params['style'] = implode(';', $styles);
			}
			$tag_string = '<img';
			foreach($params as $param => $value) {
				if (in_array($param, ['height'])) {
					continue;
				}
				if ($value != '') {
					$tag_string.=' '.$param.'="'.$value.'"';
				}
			}
			$tag_string .= '>';
			return $tag_string;
		}

		public function parseSpoiler($tag, $params, $content) {
			if(empty($content)){
				return '';
			}
			$id = fx_gen(32);
			$title = !empty($params['title']) ? htmlspecialchars($params['title']) : '';
			return '<div class="spoiler"><input tabindex="-1" type="checkbox" id="'.$id.'"><label for="'.$id.'">'.$title.'</label><div class="spoiler_body">'.$content.'</div></div>';
		}

		public function parseIframe($tag, $params, $content) {
			if(empty($params['src'])){
				return '';
			}
			return $this->getVideoCode($params['src']);
		}

		public function parseFacebookVideo($tag, $params, $content){
			$video_link = (trim(strip_tags($content)));
			$pattern = '#^(?:(?:https|http)?://)?(?:www\.)?(?:facebook\.com(?:/[^\/]+/videos/|/video\.php\?v=))([0-9]+)(?:.+)?$#x';
			preg_match($pattern, $video_link, $matches);
			if(empty($matches[1])){
				$pattern = '#^(?:(?:https|http)?://)?(?:www\.)?(?:facebook\.com(?:/[^\/]+/videos/[^\/]+))/([0-9]+)(?:.+)?$#x';
				preg_match($pattern, $video_link, $matches);
			}
			if(empty($matches[1])){
				return '';
			}
			return $this->getVideoCode('https://www.facebook.com/video/embed?video_id='.$matches[1]);
		}

		public function parseYouTubeVideo($tag, $params, $content){
			$video_id = $this->parseYouTubeVideoID(trim(strip_tags($content)));
			return $this->getVideoCode('//www.youtube.com/embed/'.$video_id);
		}

		private function getVideoCode($src) {
			return '<div class="video_wrap"><iframe class="video_frame" src="'.$src.'" frameborder="0" allowfullscreen></iframe></div>';
		}

		private function parseYouTubeVideoID($url) {
			$pattern = '#^(?:(?:https|http)?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
			preg_match($pattern, $url, $matches);
			return (isset($matches[1])) ? $matches[1] : false;
		}

	}










