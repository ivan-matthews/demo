<?php
	use Core\Classes\Kernel;
	/**
	 * @var array $content
	 */
?>
<ul class="nav nav-tabs nav-fill sorting-panel mt-1">
	<?php foreach($content['actions'] as $key=>$action){ ?>

		<?php if(!fx_equal($action['status'],Kernel::STATUS_ACTIVE)){ continue; } ?>

		<?php if(fx_equal($key,$content['current']['action'])){ ?>
			<li class="nav-item">
				<span class="nav-link active">
					<?php print fx_lang($action['title']) ?>
					<?php if(fx_equal('up',$content['current']['sort'])){ ?>
						<?php array_push($action['link'],'dn') ?>
						<a class="sorting-link" title="<?php print fx_lang('home.filter_sorting_items_up') ?>" href="<?php print fx_make_url($action['link'],array(),1) ?>">
							<i class="fas fa-angle-up"></i>
						</a>
					<?php }else{ ?>
						<?php array_push($action['link'],'up') ?>
						<a class="sorting-link" title="<?php print fx_lang('home.filter_sorting_items_down') ?>" href="<?php print fx_make_url($action['link'],array(),1) ?>">
							<i class="fas fa-angle-down"></i>
						</a>
					<?php } ?>
				</span>
			</li>
		<?php }else{ ?>
			<?php array_push($action['link'],$content['current']['sort']) ?>
			<li class="nav-item">
				<a class="nav-link" title="" href="<?php print fx_make_url($action['link'],array(),1) ?>">
					<?php print fx_lang($action['title']) ?>
				</a>
			</li>
		<?php } ?>
	<?php } ?>
</ul>