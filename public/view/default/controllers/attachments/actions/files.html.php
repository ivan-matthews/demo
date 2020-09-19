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

<div class="select-files-list row justify-content-center">

	<div class="col-12 files row">

		<?php foreach($content as $key=>$file){ ?>

			<?php $selected = in_array($file['f_id'],$ids_list) ?>

			<div class="files-item col-12 p-0 m-0">

				<a id="<?php print $file['f_id'] ?>" class="files-item-link row col-12 p-0 m-0<?php if($selected){ ?> selected<?php } ?>" onclick="attachmentsObj.selectAttachment(this,'files',<?php print $file['f_id'] ?>)">
					<div class="icon col-1">
						<div class="selected-icon col-1 pr-3 pl-1 text-center">
							<i class="fa fa-check"></i>
						</div>
						<?php print fx_get_file_icon($file['f_path']) ?>
					</div>
					<div class="name col-8">
						<?php print fx_crop_string($file['f_name']) ?>
					</div>
					<div class="size col-3">
						<i class="fas fa-sd-card"></i>
						<?php print fx_prepare_memory($file['f_size']) ?>
					</div>
				</a>

			</div>

		<?php } ?>

		<div class="col-12 show-more files justify-content-center row">
			<?php fx_show_more_button($link,$total,$limit,$offset,'.select-files-list .files') ?>
		</div>
	</div>

</div>
