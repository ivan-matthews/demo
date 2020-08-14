<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $posts */
	/** @var array $total */

	$this->prependCSS("{$this->theme_path}/css/blog");
	$this->prependJS("{$this->theme_path}/js/blog");

//	fx_die($posts)
?>

<div class="blog-list row justify-content-center">

	<?php if(fx_logged()){ ?>
		<div class="buttons col-12 text-right mb-2">
			<div class="btn-group">
				<a class="add-post btn-default radius-0 p-2" href="<?php print fx_make_url(array('blog','posts','%user_id%')) ?>">
					<i class="far fa-user"></i>
					<?php print fx_lang('blog.my_blog_posts') ?>
				</a>
				<a class="add-post btn-success radius-0 p-2" href="<?php print fx_get_url('blog','add') ?>">
					<i class="fas fa-plus"></i>
					<?php print fx_lang('blog.add_new_post') ?>
				</a>
			</div>
		</div>
	<?php } ?>

	<div class="col-12 posts row">

		<?php foreach($posts as $post){ ?>

			<div class="list-group-item list-group-item-action post-item pb-1 pt-1 radius-0">

				<div class="post-info row ">

					<div class="post-item-image col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2 pt-2">
						<img src="<?php print fx_get_image_src($post['blog_image'],$post['blog_image_date'],'small') ?>">
					</div>

					<div class="col-md-7 col-sm-8 col-9 col-lg-10 col-xl-10 post-item-info">
						<a href="<?php print fx_get_url('blog','post',$post['b_slug']) ?>">
							<div class="blog-title pt-2 pb-2">
								<?php print fx_crop_string($post['b_title'],100) ?>
							</div>
						</a>
						<div class="blog-content mt-1 mb-1">
							<?php print fx_crop_string($post['b_content'],200) ?>
						</div>
						<div class="info row col-12">
							<div class="blog-date mr-4">
								<i class="fas fa-clock"></i>
								<?php print fx_get_date($post['b_date_created']) ?>
							</div>
							<div class="blog-views">
								<i class="fas fa-eye"></i>
								<?php print $post['b_total_views'] ?>
							</div>
						</div>
					</div>

				</div>
			</div>

		<?php } ?>

	</div>
</div>
