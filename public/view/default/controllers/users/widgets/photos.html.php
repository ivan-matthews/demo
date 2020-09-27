<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $total
	 * @var array $photos
	 * @var array $user
	 */
?>

<?php if($total || fx_me($user['u_id'])){ ?>
	<div class="photos-block radius-0 mb-4 row justify-content-center">
		<a href="<?php print fx_get_url('users','photos',$user['u_id']) ?>" class="d-cnt">
			<div class="photos-block-header card-header col-12 radius-0">
				<span class="link">
					<?php print fx_lang('users.all_user_photos') ?>
				</span>
				<span class="count">
					<sup><?php print $total ?></sup>
				</span>
			</div>
		</a>
		<div class="photos-block-body col-12 row mb-2 mt-2 m-0 p-0">
			<?php if($total){ ?>
				<?php foreach($photos as $photo){ ?>
					<div class="mx-auto photos-block-body-item">
						<a class="" href="<?php print fx_get_url('photos','item',$photo['p_id']) ?>">
							<img src="<?php print fx_get_image_src($photo['p_small'],$photo['p_date_updated'],'small',$photo['p_external']) ?>">
						</a>
					</div>
				<?php } ?>
			<?php }else{ ?>
				<div class="add-new block row col-12 m-0 p-0">
					<a class="row m-0 pb-3 pt-3 p-2 col-12 justify-content-center block-link" href="<?php print fx_get_url('photos','add') ?>">
						<div class="block-icon pr-2">
							<i class="fas fa-plus"></i>
						</div>
						<div class="block-content">
							<?php print fx_lang('photos.add_new') ?>
						</div>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>