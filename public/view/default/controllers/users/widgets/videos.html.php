<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $total
	 * @var array $videos
	 * @var array $user
	 */
?>

<?php if($total || fx_me($user['u_id'])){ ?>
	<div class="videos-block radius-0 col-12 mt-2">
		<a href="<?php print fx_get_url('users','videos',$user['u_id']) ?>" class="d-cnt">
			<div class="videos-block-header card-header radius-0">
				<span class="link">
					<?php print fx_lang('users.all_user_videos') ?>
				</span>
				<span class="count">
					<sup><?php print $total ?></sup>
				</span>
			</div>
		</a>
		<div class="videos-block-body">
			<?php if($total){ ?>
				<?php foreach($videos as $video){ ?>
					<?php
					$file_info = pathinfo($video['v_name']);
					$short_name = fx_crop_string($file_info['filename'],20) . ".{$file_info['extension']}";
					?>
					<div class="videos-block-body-item">
						<a class="col-12 row m-0 p-2" href="<?php print fx_get_url('videos','item',$video['v_id']) ?>">
							<div class="icon pr-2">
								<?php print fx_get_file_icon($file_info['basename']) ?>
							</div>
							<div class="text">
								<?php print $short_name ?>
							</div>
						</a>
					</div>
				<?php } ?>
			<?php }else{ ?>
				<div class="add-new block">
					<a class="row m-0 pb-3 pt-3 p-2 block-link" href="<?php print fx_get_url('videos','add') ?>">
						<div class="block-icon pr-2">
							<i class="fas fa-plus"></i>
						</div>
						<div class="block-content">
							<?php print fx_lang('videos.add_new') ?>
						</div>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>