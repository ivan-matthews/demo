<?php
	/**
	 * @var array $content
	 * @var array $current
	 */
?>
<ul class="nav nav-tabs nav-fill sorting-panel mt-1">
	<?php foreach($content['actions'] as $key=>$action){ ?>
		<?php if(fx_equal($key,$content['current']['action'])){ ?>
			<li class="nav-item">
				<span class="nav-link active">
					<?php print fx_lang($action['title']) ?>
					<?php if(fx_equal('up',$content['current']['sort'])){ ?>
						<?php $query = array('sort'=>'dn') ?>
						<a class="sorting-link" title="<?php print fx_lang('home.filter_sorting_items_up') ?>" href="<?php print fx_make_url($action['link'],$query,null) ?>">
							<i class="fas fa-angle-up"></i>
						</a>
					<?php }else{ ?>
						<?php $query = array('sort'=>'up') ?>
						<a class="sorting-link" title="<?php print fx_lang('home.filter_sorting_items_down') ?>" href="<?php print fx_make_url($action['link'],$query,null) ?>">
							<i class="fas fa-angle-down"></i>
						</a>
					<?php } ?>
				</span>
			</li>
		<?php }else{ ?>
			<li class="nav-item">
				<a class="nav-link" title="" href="<?php print fx_make_url($action['link'],array(),null) ?>">
					<?php print fx_lang($action['title']) ?>
				</a>
			</li>
		<?php } ?>
	<?php } ?>
</ul>