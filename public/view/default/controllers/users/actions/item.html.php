<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
	unset($data['fields'][$this->config->session['csrf_key_name']]);
	$data['fields'] = $this->prepareFormFieldsToFieldSets($data['fields']);
?>

<div class="row justify-content-center user-profile col-12">

	<div class="user-left-bar col-md-6 col-sm-5 col-12 col-lg-4 col-xl-4 mb-4">

		<?php $this->renderAsset('controllers/users/widgets/user_avatar',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/user_menu',$data) ?>

	</div>

	<div class="user-right-bar col-md-12 col-sm-12 col-11 col-lg-8 col-xl-8">

		<?php $this->renderAsset('controllers/users/widgets/user_info_header',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/status_panel',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/visible_info',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/invisible_info',$data) ?>

	</div>

</div>
