<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	 */
	$this->appendCSS('comments');
//fx_die($options)
?>
<?php if($content){ ?>
	<?php if($options['wa_show_title']){ ?>
		<div class="before-content-widget-header">
			<div class="row justify-content-center widget-header">
				<div class="col-12 before-content-title title">
					<?php print fx_lang($options['wa_title']) ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="comments-list row justify-content-center comments-body-before-content-widget before-content-widget-body">
		<div class="col-12 comments row">
			<?php foreach($content as $comment){ ?>
				<?php $online = fx_is_online($comment['author_log_date']) ?>

				<a href="<?php print fx_get_url($comment['c_controller'],$comment['c_action'],$comment['c_item_id']) ?>" class="list-group-item list-group-item-action comment-item radius-0">

					<div class="comment-info row ">
						<div class="comment-icon col-2 col-sm-2 col-md-1 col-xl-1 col-lg-1 text-center">
							<div class="avatar">

								<?php fx_print_avatar($comment['author_photo'],'small',$comment['a_avatar_updated_date'],$comment['author_gender'],$comment['author_name'],$comment['author_name']) ?>

								<div title="<?php print($online?fx_lang('users.user_is_online'):fx_lang('users.user_is_offline')) ?>" class="status status-<?php print($online?'online':'offline') ?>">
									<?php print fx_get_icon_logged($comment['author_log_type']) ?>
								</div>

							</div>
						</div>
						<div class="comment-info col-10 col-sm-10 col-md-11 col-xl-11 col-lg-11">
							<div class="user-name col-12">
								<?php print $comment['author_name'] ?>
							</div>
							<div class="comment-name col-12 mt-1">
								<?php print fx_crop_string($comment['c_content'],200) ?>
							</div>
							<div class="info col-12 row mt-1">
								<div class="date pl-4">
									<i class="fas fa-clock"></i>
									<?php print fx_get_date($comment['c_date_created']) ?>
								</div>
								<div class="link pl-4">
									<i class="fas fa-link"></i>
									<?php print fx_lang('comments.show_commented_post') ?>
								</div>
							</div>
						</div>
					</div>

				</a>

			<?php } ?>
		</div>
	</div>
<?php } ?>
