<!DOCTYPE html>
<?php

	/** @var View $this */

	use Core\Classes\View;

	define('THEME_POSITIONS',array(
		'header'			=> true,
		'sidebar'			=> true,
		'top'				=> true,
		'bottom'			=> true,
		'body_header'		=> true,
		'before_content'	=> true,
		'after_content'		=> true,
		'body_footer'		=> true,
		'sidebar_footer'	=> true,
		'footer'			=> true,
	));

	$this->addCSS("libs/bootstrap");
	$this->addCSS("libs/fontawesome");

	$this->addJS("libs/jquery");
	$this->addJS("libs/func");

	$this->addCSS("index");
	$this->addCSS("home");
	$this->addJS("index");
	$this->addJS("home");

	$this->addCSS("attachments");
	$this->addJS("attachments");

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

	<body class="main-content">

		<nav class="navbar header-bar"></nav>
		<nav class="navbar header-bar fixed-top">

			<?php print $this->widget('header') ?>

		</nav>

		<main class="container mt-3">

			<div class="row justify-content-center">

				<?php print $this->widget('top') ?>

				<div class="sidebar-parent col-md-4 col-sm-3 col-3 col-lg-3 col-xl-3">

<!--					<div class="sidebar-main fixed-sidebar col-md-4 col-sm-3 col-3 col-lg-3 col-xl-3 p-0 m-0">-->
					<div class="sidebar-main">

						<?php print $this->widget('sidebar') ?>

					</div>

				</div>

				<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 content general-content controller-<?php print $this->data['current_controller'] ?>-<?php print $this->data['current_action'] ?>">

					<?php print $this->widget('body_header') ?>

					<div class="main-content mb-4">

						<?php print $this->widget('before_content') ?>

						<?php if($this->isContent()){ ?>

							<?php $this->printContent() ?>

						<?php } ?>

						<?php print $this->widget('after_content') ?>
					</div>

				</div>
				<div class="sidebar-parent col-md-4 col-sm-3 col-3 col-lg-3 col-xl-3">
					<?php print $this->widget('sidebar_footer') ?>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 content footer-content">
					<?php print $this->widget('body_footer') ?>
				</div>

				<?php print $this->widget('bottom') ?>

			</div>

		</main>

		<footer class="footer container mt-3 header-bar">

			<div class="row justify-content-center footer-block">

				<div class="footer-parent col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12">

					<?php print $this->widget('footer') ?>

				</div>

			</div>

		</footer>

		<?php
//			$this->addJS("libs/fontawesome");
			$this->addJS("libs/popper");
			$this->addJS("libs/bootstrap");
		?>
		<?php $this->renderCssFiles() ?>
		<?php $this->renderJsFiles() ?>

	</body>
</html>


