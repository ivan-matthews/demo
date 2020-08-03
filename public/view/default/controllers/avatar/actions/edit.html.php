<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $image_params */
	/** @var array $fields */
	/** @var array $form */
	/** @var array $errors */
?>

<div class="form row form-auth justify-content-center visible-avatar-form">

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 form">
		<?php print fx_lang('avatar.edit_avatar_form_title') ?>
	</div>

	<form method="POST" class="mb-3 mt-3">

		<div class="form-group row m-0 justify-content-center form-block avatar col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12">

			<div class="col-6 original">

				<div id="image-wapper">

					<img id="image_avatar" class="edit-preview-avatar" src="<?php print $this->getUploadSiteRoot($image_params['original']) ?>">

				</div>

			</div>

			<div class="col-6 preview justify-content-center">

				<?php foreach($image_params as $param_key_block=>$param_value_block){ ?>

					<div class="preview-content <?php print $param_key_block ?>">

						<img id="image_avatar" class="preview-avatar" src="<?php print $this->getUploadSiteRoot($param_value_block) ?>">

					</div>

				<?php } ?>

			</div>

		</div>

		<input type="submit" class="btn btn-default">
		<a href="javascript:void(0)" onclick="changeAvatarManipulationsForms()" class="btn btn-success">
			<?php print fx_lang('avatar.load_new_image_button') ?>
		</a>
	</form>

</div>

<div class="form row form-auth justify-content-center hidden hidden-avatar-form">

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 form">
		<?php print fx_lang('avatar.add_avatar_form_title') ?>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9">
		<?php print $this->renderForm($data) ?>
	</div>

</div>

<script>
	changeAvatarManipulationsForms = function(){
		$('.visible-avatar-form').addClass('hidden');
		$('.hidden-avatar-form').removeClass('hidden');
		return true;
	};

	$(document).ready(function(){
		cropAvatar('.visible-avatar-form');
	});
</script>