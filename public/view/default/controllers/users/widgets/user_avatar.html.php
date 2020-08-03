<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
	$this->prependCSS("{$this->theme_path}/css/avatar");
?>

<div class="user-avatar row justify-content-center">

	<div class="image">
		<?php if($user['p_normal']){ ?>
			<?php if(fx_me($user['u_id'])){ ?>
				<div class="edit">
					<a href="<?php print fx_get_url('avatar','edit',$user['u_id'],$user['p_id']) ?>">
						<i class="fas fa-pen" aria-hidden="true"></i>
					</a>
				</div>
				<div class="delete">
					<a href="<?php print fx_get_url('avatar','delete',$user['u_id'],$user['p_id']) ?>">
						<i class="fa fa-times" aria-hidden="true"></i>
					</a>
				</div>
			<?php } ?>
			<div class="view">
				<a href="<?php print fx_get_url('avatar',$user['u_id'],$user['p_id']) ?>">
					<i class="fa fa-eye" aria-hidden="true"></i>
				</a>
			</div>
		<?php }else{ ?>
			<?php if(fx_me($user['u_id'])){ ?>
				<div class="add">
					<a href="<?php print fx_get_url('avatar','add',$user['u_id']) ?>">
						<i class="fa fa-plus" aria-hidden="true"></i>
					</a>
				</div>
			<?php } ?>
		<?php } ?>

		<?php fx_print_avatar(
			$user['p_normal'],
			'normal',
			$user['p_date_updated'],
			$user['u_gender']
		) ?>
	</div>

</div>