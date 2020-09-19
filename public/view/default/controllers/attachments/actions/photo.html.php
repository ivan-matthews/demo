<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $images */

	/** @var array $total */
	/** @var array $limit */
	/** @var array $offset */
	/** @var array $link */
?>

<div class="select-photo-list row justify-content-center">

	<div class="col-12 photos row">

		<?php foreach($images as $photo){ ?>

			<div class="photos-item col-4 col-sm-4 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2">

				<a class="photos-item-link" onclick="attachmentsObj.selectImageAndAddToPreview(<?php print $photo['p_id'] ?>,'<?php print $photo['p_medium'] ?>')">

					<img class="photos-item-image" src="<?php print fx_get_image_src($photo['p_medium'],$photo['p_date_updated'],'medium') ?>"/>

				</a>

			</div>

		<?php } ?>

		<div class="col-12 show-more photo justify-content-center row">
			<?php fx_show_more_button($link,$total,$limit,$offset,'.select-photo-list .photos') ?>
		</div>
	</div>

</div>
