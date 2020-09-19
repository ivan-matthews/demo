<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $form */
	/** @var array $fields */
	/** @var array $errors */
	/** @var array $item */

	$this->prependCSS("feedback");
	$this->prependJS("feedback");
?>

<div class="form row form-reply form-auth justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 form form-title">
		<?php print fx_lang('feedback.reply_form_title') ?>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 item content item-content mt-4 p-4">
		<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 item-user mb-2 footer-line pb-2">
			<?php print fx_lang('feedback.user_say_someshit',array('%user%'	=> $item['fb_name'])) ?>
		</div>
		<?php print $item['fb_content'] ?>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 item-form">
		<?php print $this->renderForm($data) ?>
	</div>

</div>