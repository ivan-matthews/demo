<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 */

?>

<ul class="nav nav-tabs nav-fill sorting-panel mt-1">
	<?php foreach($content['header'] as $key=>$action){ ?>

		<?php if(fx_equal($key,$content['current'])){ ?>
			<li class="nav-item sorting-panel-item">
				<span class="nav-link active">
					<?php print fx_lang($action['title']) ?>
				</span>
			</li>
		<?php }else{ ?>
			<li class="nav-item">
				<a class="nav-link" title="" href="<?php print fx_make_url($action['link'],array(),1) ?>">
					<?php print fx_lang($action['title']) ?>
				</a>
			</li>
		<?php } ?>
	<?php } ?>
</ul>