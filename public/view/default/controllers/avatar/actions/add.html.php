<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
?>

<div class="form row form-auth justify-content-center original-form-block">

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 form">
		<?php print fx_lang('avatar.add_avatar_form_title') ?>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9">
		<?php print $this->renderForm($data) ?>
	</div>

</div>