<!DOCTYPE html>
<?php

	/** @var View $this */

	use Core\Classes\View;
	use Core\Classes\Language;

	define('THEME_POSITIONS',array(
		'header'			=> true,
		'sidebar'			=> true,
		'top'				=> true,
		'bottom'			=> true,
		'body_header'		=> true,
		'before_content'	=> true,
		'after_content'		=> true,
		'body_footer'		=> true,
		'footer'			=> true,
	));

	$this->addCSS("{$this->theme_path}/css/libs/bootstrap",TIME);
	$this->addCSS("{$this->theme_path}/css/libs/fontawesome",TIME);

	$this->addJS("{$this->theme_path}/js/libs/jquery",TIME);

	$this->addCSS("{$this->theme_path}/css/index",TIME);
	$this->addCSS("{$this->theme_path}/css/main",TIME);
	$this->addJS("{$this->theme_path}/js/index",TIME);
	$this->addJS("{$this->theme_path}/js/main",TIME);

	$language = Language::getInstance();
	$lang_key = $language->getLanguageKey();
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

	<body class="main-content">

		<nav class="navbar header-bar">

			<div class="container">

				<div class="row container col-12">

					<?php $this->widget('header') ?>

				</div>

			</div>

		</nav>

		<main class="container mt-3">

			<div class="row justify-content-center">

				<?php $this->widget('top') ?>

				<div class="sidebar-parent col-md-3 col-sm-3 col-3 col-lg-3 col-xl-3">

					<?php $this->widget('sidebar') ?>

				</div>

				<div class="col-md-8 col-sm-12 col-12 col-lg-9 col-xl-9 content">

					<?php $this->widget('body_header') ?>

					<div class="main-content">

						<?php $this->widget('before_content') ?>

						<?php if($this->isContent()){ ?>

							<?php $this->printContent() ?>

						<?php } ?>

						<?php $this->widget('after_content') ?>

					</div>

					<?php $this->widget('body_footer') ?>

				</div>

				<?php $this->widget('bottom') ?>

			</div>

		</main>

		<footer class="footer container mt-3 header-bar">

			<div class="row justify-content-center footer-block">

				<div class="footer-parent col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12">

					<?php $this->widget('footer') ?>

				</div>

			</div>

		</footer>

		<?php
			$this->addJS("{$this->theme_path}/js/libs/fontawesome",TIME);
			$this->addJS("{$this->theme_path}/js/libs/popper",TIME);
			$this->addJS("{$this->theme_path}/js/libs/bootstrap",TIME);
		?>
		<?php $this->renderCssFiles() ?>
		<?php $this->renderJsFiles() ?>

	</body>
</html>


