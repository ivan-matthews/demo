<!DOCTYPE html>
<?php

	use Core\Classes\View;

	/** @var View $this */

	$lang_key = $this->language->getLanguageKey();
	$translation_lang_key = $lang_key . "-" . strtoupper($lang_key);

?>
<html lang="<?php print $translation_lang_key ?>">

	<head>

		<?php $this->printTitle() ?>

		<?php $this->printMeta() ?>
		<?php $this->printFavicon() ?>

		<?php $this->renderCssFiles() ?>
		<?php $this->renderJsFiles() ?>

	</head>

	<body>

		<?php if($this->isContent()){ ?>

			<?php $this->printContent() ?>

		<?php } ?>

	</body>
</html>


