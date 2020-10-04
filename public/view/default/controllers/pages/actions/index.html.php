<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $posts */
	/** @var array $total */

	$this->prependCSS("pages");
	$this->prependJS("pages");
?>

<?php if(fx_logged()){ ?>
	<div class="buttons-panel col-12 text-right mb-1 mt-1">
		<div class="btn-group">
			<a class="add-post btn-success radius-0 p-2" href="<?php print fx_get_url('pages','add') ?>">
				<i class="fas fa-plus"></i>
				<?php print fx_lang('pages.add_new_post') ?>
			</a>
		</div>
	</div>
<?php } ?>

<?php if(!$posts){ return $this->renderEmptyPage(); } ?>

<div class="pages-list row justify-content-center">

	<div class="col-12 posts row">

		<?php foreach($posts as $post){ ?>

			<div class="list-group-item list-group-item-action post-item pb-3 pt-3 radius-0">

				<div class="post-info row ">

					<?php if($post['small_pages_image']){ ?>

						<div class="post-item-image d-none d-sm-block col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2 pt-2">
							<img src="<?php print fx_get_image_src($post['small_pages_image'],$post['pages_image_date'],'small') ?>">
						</div>

					<?php } ?>

					<div class="<?php if($post['small_pages_image']){ ?>col-md-9 col-sm-9 col-12 col-lg-10 col-xl-10<?php }else{ ?>col-12<?php } ?> post-item-info">

						<?php if(fx_me($post['u_id'])){?>
							<div class="btn-group buttons float-right">
								<a class="add-post text-success radius-0 p-1 pl-2 pr-2" href="<?php print fx_get_url('pages','edit',$post['pg_id']) ?>">
									<i class="fas fa-edit"></i>
									<?php print fx_lang('pages.edit_pages_post') ?>
								</a>
								<a class="add-post text-danger radius-0 p-1 pl-2 pr-2" href="<?php print fx_get_url('pages','delete',$post['pg_id']) ?>">
									<i class="fas fa-trash-alt"></i>
									<?php print fx_lang('pages.delete_pages_post') ?>
								</a>
							</div>
						<?php } ?>

						<a href="<?php print fx_get_url('pages','post',$post['pg_slug']) ?>">
							<div class="pages-title pt-2 pb-2">
								<?php print fx_crop_string($post['pg_title'],80) ?>
							</div>
						</a>
						<div class="pages-content mt-1 mb-1">
							<?php print fx_crop_string($post['pg_content'],200) ?>
						</div>
					</div>

					<?php if(false){?>
						<div class="info row col-12 m-0 mt-2">
							<?php if($post['ct_id']){ ?>
								<a class="pl-2 category" href="<?php print fx_make_url(array('pages'),array('cat'=>$post['ct_id'])) ?>">
									<div class="pages-views mr-2">
										<?php if($post['ct_icon']){ ?><i class="<?php print $post['ct_icon'] ?>"></i><?php } ?>
										<?php print fx_lang($post['ct_title']) ?>
									</div>
								</a>
							<?php } ?>

							<div class="pages-user mr-2">
								<a href="<?php print fx_get_url('users','item',$post['u_id']) ?>" class="p-2 user-link">
									<?php fx_print_avatar(
										$post['p_micro'],
										'micro',
										$post['p_date_updated'],
										$post['u_gender']
									) ?>
									<?php print fx_get_full_name($post['u_full_name'],$post['u_gender']) ?>
								</a>
							</div>
							<div class="pages-date mr-2">
								<i class="fas fa-clock"></i>
								<?php print fx_get_date($post['pg_date_created']) ?>
							</div>
							<div class="pages-views mr-2">
								<i class="fas fa-eye"></i>
								<?php print $post['pg_total_views'] ?>
							</div>
							<a href="<?php print fx_get_url('pages','post',$post['pg_slug'] . "#comment-list") ?>">
								<div class="pages-views mr-2">
									<i class="fas fa-comments"></i>
									<?php print $post['pg_total_comments'] ?>
								</div>
							</a>
							<div class="attachments mr-2">
								<?php print fx_count_all_attachments(fx_arr($post['pg_attachments_ids'])) ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>

		<?php } ?>

	</div>
</div>
