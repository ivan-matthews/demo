<!DOCTYPE html>
<?php

	/** @var View $this */

	use Core\Classes\View;
	use Core\Classes\Language;
	use Core\Classes\Interfaces\View as ViewInterface;

	$this->prependCSS("{$this->theme_path}/css/index",null);
	$this->prependJS("{$this->theme_path}/js/index",null);
	$this->appendJS("{$this->theme_path}/js/main",null);
	$this->appendCSS("{$this->theme_path}/css/main",null);

	$language = Language::getInstance();
	$lang_key = $language->getLanguageKey();
	$translation_lang_key = $lang_key . "-" . strtoupper($lang_key);
?>
<html lang="<?php print $translation_lang_key ?>">
	<head>
		<?php $this->renderCssFiles() ?>
		<?php $this->renderJsFiles() ?>
		<?php $this->printTitle() ?>
	</head>
	<body>
		<?php if($this->isContent()){ ?>
			<?php $this->printContent() ?>
		<?php } ?>
	</body>
</html>

<?php
	fx_pre(array(
		'files'=>get_included_files(),
		'memor'=>fx_prepare_memory(memory_get_usage(),4,',',' '),
		'times'=>number_format(microtime(true)-TIME,10),
	));

	$dbg = \Core\Classes\Response\Response::getInstance()->getDebug();
	if($dbg){
		foreach($dbg as $key=>$item){
			print "<i>{$key}</i><br>";
			foreach($item as $value){
				print $value['query'] .'<br>';
			}
			print '<hr>';
		}
	}
?>

























