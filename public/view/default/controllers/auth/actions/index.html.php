<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
?>

<div class="form row form-auth justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 form text-center">
		<?php print fx_lang('auth.title_index_form_name')?>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9">
		<?php print $this->renderForm($data) ?>

		<div class="another-data text-right">

			<span class="form-links">
				<a href="<?php print fx_get_url('auth','registration') ?>"><?php print fx_lang('auth.registration_link_title')?></a>
			</span>
			<span class="form-links">
				<a href="<?php print fx_get_url('auth','restore_password') ?>"><?php print fx_lang('auth.restore_password_link_title') ?></a>
			</span>

		</div>

	</div>

</div>