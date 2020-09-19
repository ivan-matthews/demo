<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $content */
	/** @var array $ids_list */
?>

<div class="select-audios-list row justify-content-center">

	<div class="col-12 audios row">

		<?php foreach($content as $key=>$audio){ ?>

			<?php $selected = in_array($audio['au_id'],$ids_list) ?>

			<div class="audios-item col-12 col-12 p-0 m-0">

				<a id="<?php print $audio['au_id'] ?>" class="audios-item-link row col-12 col-12 p-0 m-0<?php if($selected){ ?> selected<?php } ?>" onclick="attachmentsObj.selectAttachment(this,'audios',<?php print $audio['au_id'] ?>)">
					<div class="icon col-1">
						<div class="selected-icon col-1 pr-3 pl-1 text-center">
							<i class="fa fa-check"></i>
						</div>
						<?php print fx_get_file_icon($audio['au_path']) ?>
					</div>
					<div class="name col-9">
						<?php print fx_crop_string($audio['au_name']) ?>
					</div>
					<div class="size col-2">
						<i class="fas fa-sd-card"></i>
						<?php print fx_prepare_memory($audio['au_size']) ?>
					</div>
				</a>

			</div>

		<?php } ?>

	</div>

</div>
