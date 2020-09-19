<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
?>

<div class="form row form-auth justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 form">
		<?php print fx_lang('blog.create_blog_post_item')?>
	</div>

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12">
		<?php print $this->renderForm($data) ?>
	</div>

</div>