<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $content */
	/** @var array $ids_list */

	/** @var array $total */
	/** @var array $limit */
	/** @var array $offset */
	/** @var array $link */
?>

<div class="select-photos-list row justify-content-center">

	<div class="col-12 photos row">

		<?php foreach($content as $photo){ ?>

			<?php $selected = in_array($photo['p_id'],$ids_list) ?>

			<div class="photos-item col-4 col-sm-4 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2">

				<a id="<?php print $photo['p_id'] ?>" class="photos-item-link<?php if($selected){ ?> selected<?php } ?>" onclick="attachmentsObj.selectAttachment(this,'photos',<?php print $photo['p_id'] ?>)">
					<div class="selected-icon col-1 pr-3 pl-1 text-center">
						<i class="fa fa-check"></i>
					</div>
					<img class="photos-item-image" src="<?php print fx_get_image_src($photo['p_medium'],$photo['p_date_updated'],'medium') ?>"/>

				</a>

			</div>

		<?php } ?>

		<div class="col-12 show-more photos justify-content-center row">
			<?php fx_show_more_button($link,$total,$limit,$offset,'.select-photos-list .photos') ?>
		</div>
	</div>

</div>
