<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 */

?>

<div class="div-logo row col-3">
	<div class="visible-logo-image">
		<a href="/">
			<img class="logo" src="<?php $this->printUploadSiteRoot($this->config->view['site_logo']) ?>">
		</a>
	</div>
	<div class="hidden-logo-button pl-3 pr-3 pt-2 pb-2">
		<a href="javascript:void(0)" onclick="indexObj.sidebarActions()">
			<i class="fa fa-bars" aria-hidden="true"></i>
		</a>
	</div>
</div>
<script>

</script>