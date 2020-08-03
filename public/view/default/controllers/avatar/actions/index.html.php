<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $avatars */
	/** @var array $user */

	$this->addCSS("{$this->theme_path}/css/avatar");
	$this->addJS("{$this->theme_path}/js/avatar");
?>
	<div class="avatars-list row justify-content-center">

		<div class="col-12 avatars row">

			<?php foreach($avatars as $avatar){ ?>

				<div class="avatars-item col-4 col-sm-4 col-md-4 col-lg-3 col-xl-2 mt-2 mb-2">

					<div class="avatars-item-title">

						<?php print $avatar['p_name'] ?>

					</div>

					<a class="avatars-item-link" href="<?php print fx_get_url('avatar','item',$user['u_id'],$avatar['p_id']) ?>">

						<img onerror="indexObj.brokenImage(this,'medium')" class="avatars-item-image" src="<?php print $this->getUploadSiteRoot($avatar['p_medium']) ?>?v=<?php print $avatar['p_date_updated'] ?>"/>

						<div class="avatars-item-date">

							<?php print fx_get_date($avatar['p_date_updated']) ?>

						</div>

					</a>

				</div>

			<?php } ?>

		</div>

	</div>
