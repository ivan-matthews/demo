<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $post */
	/** @var array $attachments */

	$this->prependCSS("news");
	$this->prependJS("news");
?>

<div class="news-item row justify-content-center">

	<div class="col-12 col-sm-12 col-md-12 col-lg-11 col-xl-10 title-block row justify-content-center">
		<div class="news-title">
			<?php print $post['nw_title'] ?>
		</div>
	</div>
	<div class="col-12 mb-2 head-menu">
		<div class="float-left left-bar">
			<div class="date-upd col-12">
				<?php if($post['nw_date_updated']){ ?>
					<i class="far fa-hourglass"></i>
					<?php print fx_lang('news.date_updated_value') ?>
					<?php print fx_get_date($post['nw_date_updated']) ?>
				<?php } ?>
			</div>
		</div>
		<?php if(fx_me($post['u_id'])){ ?>
			<div class="btn-group float-right right-bar">
				<a class="add-post btn-success radius-0 p-1 pl-2 pr-2" href="<?php print fx_make_url(array('news','edit',$post['nw_id'])) ?>">
					<i class="fas fa-edit"></i>
					<?php print fx_lang('news.edit_news_post') ?>
				</a>
				<a class="add-post btn-danger radius-0 p-1 pl-2 pr-2" href="<?php print fx_get_url('news','delete',$post['nw_id']) ?>">
					<i class="fas fa-trash-alt"></i>
					<?php print fx_lang('news.delete_news_post') ?>
				</a>
			</div>
		<?php } ?>
	</div>
	<div class="col-12 news-post row">
		<div class="right-bar col-12">
			<?php if($post['normal_news_image'] && $post['nw_show_image_in_item']){ ?>
				<a href="<?php print fx_get_url('photos','item',$post['news_image_id']) ?>">
					<div class="post-image float-left pb-2 pr-4">
						<img src="<?php print fx_get_image_src($post['normal_news_image'],$post['news_image_date'],'normal') ?>"/>
					</div>
				</a>
			<?php } ?>
			<div class="news-content">
				<?php print $post['nw_content'] ?>
			</div>
		</div>
	</div>
	<div class="row col-12 attachments mt-2 pt-1">
		<?php fx_render_attachments($attachments) ?>
	</div>
	<div class="col-12 post-info row mt-4">
		<?php if($post['ct_id']){ ?>
			<a class="pl-2 category" href="<?php print fx_make_url(array('news'),array('cat'=>$post['ct_id'])) ?>">
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
		<div class="news-views mr-2">
			<i class="fas fa-comments"></i>
			<?php print $post['nw_total_comments'] ?>
		</div>
	</div>
</div>
