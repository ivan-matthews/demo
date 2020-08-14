<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $images */
	
	$this->prependCSS("{$this->theme_path}/css/avatar");
?>

<div class="select-avatars-list row justify-content-center">

	<div class="col-12 avatars row">

		<?php foreach($images as $avatar){ ?>

			<div class="avatars-item col-4 col-sm-4 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2">

				<a class="avatars-item-link" onclick="selectImageAndAddToPreview(<?php print $avatar['p_id'] ?>,'<?php print $this->getUploadSiteRoot($avatar['p_medium']) ?>')">

					<img class="avatars-item-image" src="<?php print fx_get_image_src($avatar['p_medium'],$avatar['p_date_updated'],'medium') ?>"/>

				</a>

			</div>

		<?php } ?>

	</div>

</div>
