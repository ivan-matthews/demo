<?php
	/** @var \Core\Classes\View $this */

	$router = Core\Classes\Router::getInstance();
?>

<div class="error error404">
	<div class="error-title">
		<?php print fx_lang('home.error_head') ?>
	</div>
	<div class="error-header text-warning">
		404
	</div>
	<div class="error-body pr-4 pl-4 pb-2 text-center mb-5">
		<?php print fx_lang('home.error404_description',array(
			'%REQUEST_PAGE%'	=> $router->getAbsoluteUrl(),
			'%SITE_PROTO%'		=> $this->config->core['site_scheme'],
			'%SITE_HOST%'		=> $this->config->core['site_host']
		)) ?>
	</div>
</div>