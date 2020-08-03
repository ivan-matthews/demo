<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $menu
	 * @var array $groups
	 * @var array $fields
	 * @var array $photos
	 * @var int $total_photos
	 */

	unset($data['fields'][$this->config->session['csrf_key_name']]);
	$data['fields'] = $this->prepareFormFieldsToFieldSets($data['fields']);
?>

<div class="row justify-content-center user-profile col-12">

	<div class="user-left-bar col-md-6 col-sm-5 col-12 col-lg-4 col-xl-4 mb-4">

		<?php $this->renderAsset('controllers/users/widgets/user_avatar',$data) ?>

		<div class="row justify-content-center user-info-panel m-0 p-0">
			<div class="card radius-0 col-12 p-0 m-0 mt-2 user-card">

				<div class="card-header pt-2 pb-2">
					<?php print fx_lang('users.registration_date') ?>
				</div>
				<ul class="list-group list-group-flush card-body p-0 pb-0 mb-0">
					<li class="list-group-item pt-2 pb-2 reg-date">
						<?php print fx_get_date($user['u_date_created']) ?>
					</li>
				</ul>
				<div class="card-header pt-2 pb-2">
					<?php print fx_lang('users.user_groups_list',array('%full_name%'=>'')) ?>
				</div>
				<ul class="list-group list-group-flush card-body p-0 pt-0 pb-0">
					<li class="list-group-item pt-2 pb-2 user-groups">
						<?php
							$groups_string = '';
							foreach($groups as $group){
								$groups_string .= "<div class=\"user-group {$group['ug_name']}\">";
								$groups_string .= fx_lang("users.user_group_{$group['ug_name']}");
								$groups_string .= "</div> ";
							}
							$groups_string = rtrim($groups_string,', ');
							print $groups_string
						?>
					</li>
				</ul>
			</div>
		</div>

		<?php $this->renderAsset('controllers/users/widgets/user_menu',$data) ?>

	</div>

	<div class="user-right-bar col-md-12 col-sm-12 col-11 col-lg-8 col-xl-8">

		<?php $this->renderAsset('controllers/users/widgets/user_info_header',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/status_panel',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/visible_info',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/invisible_info',$data) ?>

		<?php if($total_photos){ ?>
			<div class="avatars-block radius-0 mb-4 row justify-content-center">
				<a href="<?php print fx_get_url('avatar','index',$user['u_id']) ?>" class="d-cnt">
					<div class="avatars-block-header card-header col-12 radius-0">
						<span class="link">
							<?php print fx_lang('users.all_user_photos') ?>
						</span>
						<span class="count">
							<sup><?php print $total_photos ?></sup>
						</span>
					</div>
				</a>
				<div class="avatars-block-body col-12 row mb-2 mt-2">
					<?php foreach($photos as $photo){ ?>
						<div class="mx-auto avatars-block-body-item">
							<a class="" href="<?php print fx_get_url('avatar','item',$user['u_id'],$photo['p_id']) ?>">
								<img src="<?php print fx_get_image_src($photo['p_small'],$photo['p_date_updated'],'small') ?>">
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>

	</div>

</div>
