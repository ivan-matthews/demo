<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	 */
	$this->appendCSS('news');
//fx_die($options)
?>
<?php if($content){ ?>
	<?php if($options['wa_show_title']){ ?>
		<a href="<?php print fx_get_url('news','index') ?>" class="before-content-widget-header">
			<div class="row justify-content-center widget-header">
				<div class="col-12 before-content-title title">
					<?php print fx_lang($options['wa_title']) ?>
				</div>
			</div>
		</a>
	<?php } ?>
	<div class="news-list row justify-content-center before-content-widget-body">
		<div class="col-12 posts row">
			<?php foreach($content as $post){ ?>

				<div class="list-group-item list-group-item-action post-item p-0 pb-3 pt-3 radius-0">

					<div class="post-info row ">

						<?php if($post['normal_news_image']){ ?>

							<div class="post-item-image d-none d-sm-block col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2 pt-2">
								<img src="<?php print fx_get_image_src($post['small_news_image'],$post['news_image_date'],'small') ?>">
							</div>

						<?php } ?>

						<div class="<?php if($post['small_news_image']){ ?>col-md-9 col-sm-9 col-12 col-lg-10 col-xl-10<?php }else{ ?>col-12<?php } ?> post-item-info">
							<a href="<?php print fx_get_url('news','post',$post['nw_slug']) ?>">
								<div class="news-title pt-2 pb-2">
									<?php print fx_crop_string($post['nw_title'],80) ?>
								</div>
							</a>
							<div class="news-content mt-1 mb-1">
								<?php print fx_crop_string($post['nw_content'],200) ?>
							</div>
						</div>

						<div class="info row col-12 m-0 mt-2">
							<?php if($post['ct_id']){ ?>
								<a class="pl-1 category" href="<?php print fx_make_url(array('news'),array('cat'=>$post['ct_id'])) ?>">
									<div class="news-views mr-2">
										<?php if($post['ct_icon']){ ?><i class="<?php print $post['ct_icon'] ?>"></i><?php } ?>
										<?php print fx_lang($post['ct_title']) ?>
									</div>
								</a>
							<?php } ?>

							<div class="news-user mr-2">
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
							<div class="news-date mr-2">
								<i class="fas fa-clock"></i>
								<?php print fx_get_date($post['nw_date_created']) ?>
							</div>
							<div class="news-views mr-2">
								<i class="fas fa-eye"></i>
								<?php print $post['nw_total_views'] ?>
							</div>
							<a href="<?php print fx_get_url('news','post',$post['nw_slug'] . "#comment-list") ?>">
								<div class="news-views mr-2">
									<i class="fas fa-comments"></i>
									<?php print $post['nw_total_comments'] ?>
								</div>
							</a>
							<div class="attachments mr-2">
								<?php print fx_count_all_attachments(fx_arr($post['nw_attachments_ids'])) ?>
							</div>
						</div>
					</div>
				</div>

			<?php } ?>
		</div>
	</div>
<?php } ?>