<!DOCTYPE html>
<?php

	/** @var View $this */

	use Core\Classes\View;
	use Core\Classes\Language;

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

		<?php $this->printTitle() ?>

		<?php $this->printMeta() ?>

		<?php $this->renderCssFiles() ?>

		<?php $this->renderJsFiles() ?>

	</head>

	<body>

		<?php $this->widget('sidebar') ?>

		<?php if($this->isContent()){ ?>

			<?php $this->printContent() ?>

		<?php } ?>

	</body>

	<?php $this->renderCssFiles() ?>
	<?php $this->renderJsFiles() ?>

</html>



























