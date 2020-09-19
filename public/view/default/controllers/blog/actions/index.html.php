<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $posts */
	/** @var array $total */

	$this->prependCSS("{$this->theme_path}/css/blog");
	$this->prependJS("{$this->theme_path}/js/blog");

//	fx_die($posts)
?>

<?php if(fx_logged()){ ?>
	<div class="buttons-panel col-12 text-right mb-1 mt-1">
		<div class="btn-group">
			<a class="add-post btn-success radius-0 p-2" href="<?php print fx_get_url('blog','add') ?>">
				<i class="fas fa-plus"></i>
				<?php print fx_lang('blog.add_new_post') ?>
			</a>
		</div>
	</div>
<?php } ?>

<?php if(!$posts){ return $this->renderEmptyPage(); } ?>

<div class="blog-list row justify-content-center">

	<div class="col-12 posts row">

		<?php foreach($posts as $post){ ?>

			<div class="list-group-item list-group-item-action post-item pb-3 pt-3 radius-0">

				<div class="post-info row ">

					<?php if($post['blog_image']){ ?>

						<div class="post-item-image col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2 pt-2">
							<img src="<?php print fx_get_image_src($post['blog_image'],$post['blog_image_date'],'small') ?>">
						</div>

					<?php } ?>

					<div class="<?php if($post['blog_image']){ ?>col-md-7 col-sm-8 col-9 col-lg-10 col-xl-10<?php }else{ ?>col-12<?php } ?> post-item-info">

						<?php if(fx_me($post['u_id'])){?>
							<div class="btn-group buttons float-right">
								<a class="add-post text-success radius-0 p-1 pl-2 pr-2" href="<?php print fx_get_url('blog','edit',$post['b_id']) ?>">
									<i class="fas fa-edit"></i>
									<?php print fx_lang('blog.edit_blog_post') ?>
								</a>
								<a class="add-post text-danger radius-0 p-1 pl-2 pr-2" href="<?php print fx_get_url('blog','delete',$post['b_id']) ?>">
									<i class="fas fa-trash-alt"></i>
									<?php print fx_lang('blog.delete_blog_post') ?>
								</a>
							</div>
						<?php } ?>

						<a href="<?php print fx_get_url('blog','post',$post['b_slug']) ?>">
							<div class="blog-title pt-2 pb-2">
								<?php print fx_crop_string($post['b_title'],80) ?>
							</div>
						</a>
						<div class="blog-content mt-1 mb-1">
							<?php print fx_crop_string($post['b_content'],200) ?>
						</div>
					</div>

					<div class="info row col-12 m-0 mt-2">
						<?php if($post['ct_id']){ ?>
							<a class="pl-2 category" href="<?php print fx_make_url(array('blog'),array('cat'=>$post['ct_id'])) ?>">
								<div class="blog-views mr-2">
									<?php if($post['ct_icon']){ ?><i class="<?php print $post['ct_icon'] ?>"></i><?php } ?>
									<?php print fx_lang($post['ct_title']) ?>
								</div>
							</a>
						<?php } ?>

						<div class="blog-user mr-2">
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
						<div class="blog-date mr-2">
							<i class="fas fa-clock"></i>
							<?php print fx_get_date($post['b_date_created']) ?>
						</div>
						<div class="blog-views mr-2">
							<i class="fas fa-eye"></i>
							<?php print $post['b_total_views'] ?>
						</div>
						<a href="<?php print fx_get_url('blog','post',$post['b_slug'] . "#comment-list") ?>">
							<div class="blog-views mr-2">
								<i class="fas fa-comments"></i>
								<?php print $post['b_total_comments'] ?>
							</div>
						</a>
					</div>
				</div>
			</div>

		<?php } ?>

	</div>
</div>
