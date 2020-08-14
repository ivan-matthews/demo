<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $content */

	$this->prependCSS("{$this->theme_path}/css/comments");
	$this->prependJS("{$this->theme_path}/js/comments");
	/*
		[c_id] => 100
		[c_author_id] => 5
		[c_receiver_id] => 1
		[c_parent_id] =>
		[c_parent_count] =>
		[c_controller] => blog
		[c_action] =>
		[c_item_id] => 7
		[с_status] => 1
		[с_public] => 1
		[c_content] => sunt in culpa qui officia deserunt mollit anim id est laborum
		[c_date_created] => 1596923751
		[c_date_updated] =>
		[c_date_deleted] =>
		[author_name] => Хяфо Зилузэщы
		[author_gender] => 3
		[author_log_type] => 5
		[author_log_date] => 1596848565
		[a_avatar_updated_date] => 1596848565
		[author_photo] =>
		[user_name] => Admin Pitrovich
		[user_gender] => 1
		[user_log_type] => 8
		[user_log_date] => 1596925006
		[u_avatar_updated_date] => 1596925006
		[user_photo] => users/1/avatars/small-1-edf7cae3bedf012fe83d424f5357f4a1.jpeg
		[parent_content] =>
		[hash] =>
	*/
?>

<div class="row justify-content-center comments comments-list mt-0 mb-4">

	<div class="comments-title p-3 col-12 row">
		<div class="comments-title-value">
			<?php print fx_lang('comments.comments_widget_title') ?>
		</div>
		<div class="comments-title-total-count ml-2">
			<sup>
				<?php print $content['total'] ?>
			</sup>
		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 p-0 list-group comments">

		<?php foreach($content['comments'] as $comment){ ?>

			<?php $author_link = fx_get_url('users','item',$comment['c_author_id']) ?>
			<?php $im = fx_equal($content['author_id'],$comment['c_author_id']) ?>
			<?php $me = fx_equal($content['author_id'],$comment['c_receiver_id']) ?>
			<?php $online = fx_is_online($comment['author_log_date']) ?>

			<div class="list-group-item list-group-item-action comments-item pb-1 pt-1 radius-0 <?php print($me?'me':null) ?>">

				<div class="comments-info row ">

					<div class="col-12 row ml-0">

						<a href="<?php print $author_link ?>" class="comments-item-avatar col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2">

							<div class="avatar">

								<?php fx_print_avatar($comment['author_photo'],'small',$comment['a_avatar_updated_date'],$comment['author_gender'],$comment['author_name'],$comment['author_name']) ?>

								<div title="<?php print($online?fx_lang('comments.comment_is_online'):fx_lang('comments.comment_is_offline')) ?>" class="status status-<?php print($online?'online':'offline') ?>">
									<?php print fx_get_icon_logged($comment['author_log_type']) ?>
								</div>

							</div>
						</a>

						<div class="col-md-7 col-sm-8 col-9 col-lg-10 col-xl-10 comments-item-info">
							<a href="<?php print $author_link ?>" class="mb-2 row">
								<div class="list-group-item-heading info full-name p-1">
									<?php print fx_get_full_name($comment['author_name'],$comment['author_gender']) ?>
								</div>
							</a>

							<div class="list-group-item-text comments-item-descriptions">
								<?php if($comment['parent_content']){ ?>
									<?php $user_link = fx_get_url('users','item',$comment['c_receiver_id']) ?>
									<span class="receiver">
										<a href="<?php print $user_link ?>" class="receiver-link">
											<?php fx_print_avatar(
												$comment['user_photo'],
												'micro',
												$comment['a_avatar_updated_date'],
												$comment['user_gender'],
												$comment['user_name'],
												$comment['user_name']
											) ?>
											<?php print fx_get_full_name($comment['user_name'],$comment['user_gender']) ?>,
										</a>
										<blockquote>
											<?php print fx_crop_string($comment['parent_content'],100) ?>
										</blockquote>
									</span>
								<?php } ?>

								<div class="comment-content p-2 row <?php print($im?'me':'not-me') ?>">
									<?php print $comment['c_content'] ?>
								</div>

							</div>

						</div>
						<div class="comment-info text-right col-12 row mt-2 mb-2">

							<div class="links col-12 row pt-2">
								<div class="date-created ml-2">
									<i class="fas fa-stopwatch"></i>
									<?php print fx_get_date($comment['c_date_created']) ?>
								</div>

								<a class="ml-3 text-success" href="/comment/ans">
									<i class="fas fa-reply"></i>
									ответить
								</a>
								<a class="ml-3 text-default" href="/comment/red">
									<i class="fas fa-pen-alt"></i>
									изменить
								</a>
								<a class="ml-3 text-danger" href="/comm/del">
									<i class="fas fa-trash"></i>
									удалить
								</a>
							</div>

						</div>

					</div>
				</div>

			</div>

		<?php } ?>

	</div>

</div>