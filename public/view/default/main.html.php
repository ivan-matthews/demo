<!DOCTYPE html>
<?php

	/** @var View $this */

	use Core\Classes\View;
	use Core\Classes\Language;

	$this->prependCSS("{$this->theme_path}/css/index",TIME);
	$this->prependJS("{$this->theme_path}/js/index",TIME);
	$this->appendJS("{$this->theme_path}/js/main",TIME);
	$this->appendCSS("{$this->theme_path}/css/main",TIME);
	$this->addJS("{$this->theme_path}/js/libs/jquery");

	$language = Language::getInstance();
	$lang_key = $language->getLanguageKey();
	$translation_lang_key = $lang_key . "-" . strtoupper($lang_key);

?>
<html lang="<?php print $translation_lang_key ?>">

	<head>

		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

		<?php $this->printTitle() ?>

		<?php $this->printMeta() ?>

		<?php $this->renderCssFiles() ?>
		<?php $this->renderJsFiles() ?>

	</head>

	<body class="main-content">

		<nav class="navbar header-bar">

			<div class="container">

				<div class="row">

					<?php $this->widget('header') ?>

				</div>

			</div>

		</nav>

		<main class="container mt-3">

			<div class="row justify-content-center">

				<div class="sidebar-parent col-md-3 col-sm-3 col-3 col-lg-3 col-xl-3">

					<?php $this->widget('sidebar') ?>

				</div>

				<div class="col-md-8 col-sm-12 col-12 col-lg-9 col-xl-9 content">

					<?php $this->widget('body_header') ?>

					<div class="main-content">

						<?php if($this->isContent()){ ?>

							<?php $this->printContent() ?>

						<?php } ?>

					</div>

					<?php $this->widget('body_footer') ?>

				</div>

			</div>

		</main>

		<footer class="footer container mt-3 header-bar">

			<div class="row justify-content-center footer-block">

				<div class="footer-parent col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12">

					<?php $this->widget('footer') ?>

				</div>

			</div>

		</footer>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/840d7517f0.js" crossorigin="anonymous"></script>

		<?php $this->renderCssFiles() ?>
		<?php $this->renderJsFiles() ?>
	</body>
</html>


