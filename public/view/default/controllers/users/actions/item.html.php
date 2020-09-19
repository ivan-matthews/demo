<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $menu
	 * @var array $groups
	 * @var array $fields
	 *
	 * @var array $photos
	 * @var array $audios
	 * @var array $videos
	 * @var array $files
	 *
	 * @var int $total_photos
	 * @var int $total_audios
	 * @var int $total_videos
	 * @var int $total_files
	 */

	unset($data['fields'][$this->config->session['csrf_key_name']]);
	$data['fields'] = $this->prepareFormFieldsToFieldSets($data['fields']);
?>

<div class="row justify-content-center user-profile col-12 m-0">

	<div class="user-left-bar col-md-12 col-sm-12 col-12 col-lg-4 col-xl-4 mb-4">

		<?php $this->renderAsset('controllers/users/widgets/user_avatar',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/user_menu',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/user_info_block',array(
			'user'	=> $user,
			'groups'=> $groups
		)) ?>

		<div class="row">
			<?php $this->renderAsset('controllers/users/widgets/videos',array(
				'total'	=> $total_videos,
				'videos'=> $videos,
				'user'	=> $user
			)) ?>

			<?php $this->renderAsset('controllers/users/widgets/audios',array(
				'total'	=> $total_audios,
				'audios'=> $audios,
				'user'	=> $user
			)) ?>

			<?php $this->renderAsset('controllers/users/widgets/files',array(
				'total'	=> $total_files,
				'files'	=> $files,
				'user'	=> $user
			)) ?>
		</div>

	</div>

	<div class="user-right-bar col-md-12 col-sm-12 col-12 col-lg-8 col-xl-8">

		<?php $this->renderAsset('controllers/users/widgets/user_header',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/status_panel',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/visible_info',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/invisible_info',$data) ?>

		<?php $this->renderAsset('controllers/users/widgets/photos',array(
			'total'	=> $total_photos,
			'photos'=> $photos,
			'user'	=> $user
		)) ?>

	</div>

</div>
