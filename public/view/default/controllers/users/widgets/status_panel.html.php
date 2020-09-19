<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
?>

<?php if($user['s_content']){ ?>
	<div class="user-status pt-1">
		<?php print $user['s_content'] ?>
		<span class="date-add">
			(<?php print fx_get_date($user['s_date_updated']?$user['s_date_updated']:$user['s_date_created']) ?>)
		</span>
		<?php if(fx_me($user['u_id'])){ ?>
			<div class="status-menu mt-2">
				<span class="edit-status">
					<a href="<?php print fx_get_url('status','edit',$user['u_id'],$user['s_id']) ?>">
						<i class="fas fa-pen"></i>
						<?php print fx_lang('users.change_status') ?>
					</a>
				</span>
				<span class="delete-status">
					<a href="<?php print fx_get_url('status','delete',$user['u_id'],$user['s_id']) ?>">
						<i class="fas fa-times"></i>
						<?php print fx_lang('users.delete_status') ?>
					</a>
				</span>
			</div>
		<?php } ?>
	</div>
<?php }else{ ?>
	<?php if(fx_me($user['u_id'])){ ?>
		<div class="status-menu">
			<span class="edit-status">
				<a href="<?php print fx_get_url('status','add',$user['u_id']) ?>">
					<i class="fas fa-pen"></i>
					<?php print fx_lang('users.added_status') ?>
				</a>
			</span>
		</div>
	<?php } ?>
<?php } ?>