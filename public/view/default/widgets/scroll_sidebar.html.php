<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 */

	$this->addCSS("scroll");
	$this->addJS("scroll");
?>
<div class="top_up_panel_button m-auto hidden" style="background: rgba(74, 118, 166, 0.1);" onclick="scrollObj.upToTopClick()">
	<div id="up" style="">
		<div class="top-up-icon">
			<i class="fas fa-angle-up"></i>
		</div>
		<div class="top-up-content"></div>
	</div>
	<div id="down" style="display: none;">
		<div class="top-up-content"></div>
		<div class="top-up-icon">
			<i class="fas fa-angle-down"></i>
		</div>
	</div>
</div>
