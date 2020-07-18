<?php /** @var \Core\Classes\View $this */ ?>
<div class="error error405">
	<div class="error-title">
		<?php print fx_lang('home.error_head') ?>
	</div>
	<div class="error-header text-warning">
		405
	</div>
	<div class="error-body">
		<?php print fx_lang('home.error405_description',array(
			'%METHOD%'	=> $this->request->getRequestMethod()
		)) ?>
	</div>
</div>