<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
?>

<div class="form row form-auth justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 form">
		<?php print fx_lang('faq.new_answer_form_title')?>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-10 col-xl-10">
		<?php print $this->renderForm($data) ?>
	</div>

</div>