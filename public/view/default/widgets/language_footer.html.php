<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 */

?>

<style>
	.language-invisible-json-content{
		display: none;
	}
</style>

<div class="language language-invisible-json-content">
	<?php print htmlspecialchars(
		json_encode(
			$content,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES
		)
	) ?>
</div>