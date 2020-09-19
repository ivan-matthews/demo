<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
?>
<div class="row col-12 attachments-list m-0 p-0">
	<?php foreach($data as $attachment_type=>$attachment){ ?>
		<?php if(!$attachment){ continue; } ?>

		<div class="col-12 row m-0 p-1 pl-2 attachments-header-item">
			<?php print fx_lang("attachments.{$attachment_type}_attachments_head") ?>
			<sub><?php print count($attachment) ?></sub>
		</div>

		<?php if(fx_equal($attachment_type,'photos')){ ?>
			<div class="justify-content-center parent-photos row col-12 attachments-body-item p-0 m-0">
				<?php foreach($attachment as $item){ ?>
					<div class="photos p-1">
						<a href="<?php print fx_get_url('photos','item',$item['p_id']) ?>">
							<div class="image">
								<img src="<?php print fx_get_image_src($item['p_small'],$item['p_date_updated'],'small') ?>">
							</div>
						</a>
					</div>
				<?php } ?>
			</div>
			<?php continue; ?>
		<?php } ?>
		<?php if(fx_equal($attachment_type,'videos')){ ?>
			<div class="videos col-12 row mr-0 pr-0 justify-content-center m-0 p-0 attachments-body-item">
				<?php foreach($attachment as $item){ ?>
					<a href="<?php print fx_get_url('videos','item',$item['v_id']) ?>" class="col-12 row">
						<div class="icon col-1">
							<?php print fx_get_file_icon($item['v_name']) ?>
						</div>
						<div class="name col-8">
							<?php print fx_crop_file_name($item['v_name'],30) ?>
						</div>
						<div class="size col-3">
							<i class="fas fa-sd-card"></i>
							<?php print fx_prepare_memory($item['v_size']) ?>
						</div>
					</a>
				<?php } ?>
			</div>
			<?php continue; ?>
		<?php } ?>
		<?php if(fx_equal($attachment_type,'audios')){ ?>
			<div class="audios col-12 row mr-0 pr-0 justify-content-center m-0 p-0 attachments-body-item">
				<?php foreach($attachment as $item){ ?>
					<a href="<?php print fx_get_url('audios','item',$item['au_id']) ?>" class="col-12 row">
						<div class="icon col-1">
							<?php print fx_get_file_icon($item['au_name']) ?>
						</div>
						<div class="name col-8">
							<?php print fx_crop_file_name($item['au_name'],30) ?>
						</div>
						<div class="size col-3">
							<i class="fas fa-sd-card"></i>
							<?php print fx_prepare_memory($item['au_size']) ?>
						</div>
					</a>
				<?php } ?>
			</div>
			<?php continue; ?>
		<?php } ?>
		<?php if(fx_equal($attachment_type,'files')){ ?>
			<div class="files col-12 row mr-0 pr-0 justify-content-center m-0 p-0 attachments-body-item">
				<?php foreach($attachment as $item){ ?>
					<a href="<?php print fx_get_url('files','item',$item['f_id']) ?>" class="col-12 row">
						<div class="icon col-1">
							<?php print fx_get_file_icon($item['f_name']) ?>
						</div>
						<div class="name col-8">
							<?php print fx_crop_file_name($item['f_name'],30) ?>
						</div>
						<div class="size col-3">
							<i class="fas fa-sd-card"></i>
							<?php print fx_prepare_memory($item['f_size']) ?>
						</div>
					</a>
				<?php } ?>
			</div>
			<?php continue; ?>
		<?php } ?>
	<?php } ?>
</div>