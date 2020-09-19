<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */

	$this->prependCSS("{$this->theme_path}/css/photos");
	$this->prependJS("{$this->theme_path}/js/photos");
?>

<div class="form row form-auth justify-content-center original-form-block">

	<div class="row justify-content-center col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 form">
		<?php print fx_lang('photos.add_photos_form') ?>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12">
		<?php print $this->renderForm($data) ?>
	</div>

</div>