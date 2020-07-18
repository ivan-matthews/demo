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
		« <?php print $user['s_content'] ?> »
		<?php if(fx_me($user['u_id'])){ ?>
			<div class="status-menu mt-2">
				<span class="edit-status">
					<a href="/status/1/edit">
						<i class="fas fa-pen"></i>
						изменить статус
					</a>
				</span>
				<span class="delete-status">
					<a href="/status/1/deete">
						<i class="fas fa-times"></i>
						удалить статус
					</a>
				</span>
			</div>
		<?php } ?>
	</div>
<?php }else{ ?>
	<?php if(fx_me($user['u_id'])){ ?>
		<div class="status-menu">
			<span class="edit-status">
				<a href="/status/1/edit">
					<i class="fas fa-pen"></i>
					изменить статус
				</a>
			</span>
		</div>
	<?php } ?>
<?php } ?>