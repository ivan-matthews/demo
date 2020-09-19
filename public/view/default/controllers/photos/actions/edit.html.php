<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $fields */
	/** @var array $form */
	/** @var array $errors */
	/** @var array $photo */
?>

<div class="form justify-content-center">

	<div class="row col-12">
		<div class="col-md-12 col-sm-12 col-12 col-lg-6 col-xl-6">

			<div class="image-block">
				<img src="<?php print fx_get_image_src($photo['p_big'],$photo['p_date_updated'],'big') ?>">
			</div>

		</div>

		<div class="col-md-12 col-sm-12 col-12 col-lg-6 col-xl-6">
			<?php print $this->renderForm($data) ?>
		</div>
	</div>

</div>
