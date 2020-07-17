<!DOCTYPE html>
<?php  /** @var View $this */

	use Core\Classes\View;
	use Core\Classes\Language;

	View::prependCSS("{$this->theme_path}/css/index",null);
	View::prependJS("{$this->theme_path}/js/index",null);
	View::appendJS("{$this->theme_path}/js/main",null);
	View::appendCSS("{$this->theme_path}/css/main",null);

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



























