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

<div class="select-videos-list row justify-content-center">

	<div class="col-12 videos row">

		<?php foreach($content as $key=>$video){ ?>

			<?php $selected = in_array($video['v_id'],$ids_list) ?>

			<div class="videos-item col-12 col-12 p-0 m-0">

				<a id="<?php print $video['v_id'] ?>" class="videos-item-link row col-12 col-12 p-0 m-0<?php if($selected){ ?> selected<?php } ?>" onclick="attachmentsObj.selectAttachment(this,'videos',<?php print $video['v_id'] ?>)">
					<div class="icon col-1">
						<div class="selected-icon col-1 pr-3 pl-1 text-center">
							<i class="fa fa-check"></i>
						</div>
						<?php print fx_get_file_icon($video['v_path']) ?>
					</div>
					<div class="name col-9">
						<?php print fx_crop_string($video['v_name']) ?>
					</div>
					<div class="size col-2">
						<i class="fas fa-sd-card"></i>
						<?php print fx_prepare_memory($video['v_size']) ?>
					</div>
				</a>

			</div>

		<?php } ?>

		<div class="col-12 show-more videos justify-content-center row">
			<?php fx_show_more_button($link,$total,$limit,$offset,'.select-videos-list .videos') ?>
		</div>
	</div>

</div>
