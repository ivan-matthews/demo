<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $post */

	$this->prependCSS("{$this->theme_path}/css/blog");
	$this->prependJS("{$this->theme_path}/js/blog");
?>

<div class="blog-item row justify-content-center mb-4">

	<div class="col-10 title-block row justify-content-center mb-4">
		<div class="blog-title">
			<?php print $post['b_title'] ?>
		</div>
	</div>
	<?php if(fx_me($post['u_id'])){ ?>
		<div class="buttons col-12 text-right mb-2">
			<div class="btn-group">
				<a class="add-post btn-success radius-0 p-1 pl-2 pr-2" href="<?php print fx_make_url(array('blog','edit',$post['b_id'])) ?>">
					<i class="fas fa-edit"></i>
					<?php print fx_lang('blog.edit_blog_post') ?>
				</a>
				<a class="add-post btn-danger radius-0 p-1 pl-2 pr-2" href="<?php print fx_get_url('blog','delete',$post['b_id']) ?>">
					<i class="fas fa-trash-alt"></i>
					<?php print fx_lang('blog.delete_blog_post') ?>
				</a>
			</div>
		</div>
	<?php } ?>
	<div class="col-12 blog-post row">
		<div class="right-bar col-12">
			<?php if($post['blog_image']){ ?>
				<div class="post-image float-left pb-2 pr-4">
					<img src="<?php print fx_get_image_src($post['blog_image'],$post['blog_image_date'],'normal') ?>"/>
				</div>
			<?php } ?>
			<div class="blog-content">
				<?php print $post['b_content'] ?>
			</div>
		</div>
	</div>
	<div class="col-12 post-info row mt-4">
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
	</div>
</div>
