<?php
	/** @var \Core\Classes\View $this */
	$year = date('Y');
?>

<div class="footer footer-menu-info">
	<?php if($data['options']['show_title']){ ?>
		<div class="footer-title<?php print ' ' . $data['options']['css_class_title'] ?>">
			<div class="title">
				<?php print fx_lang($data['options']['title']) ?>
			</div>
		</div>
	<?php } ?>
	<div class="footer-body">
		<div class="body mx-auto">
			<span class="site-year">
				<?php print $this->config->core['site_year'] ?>
				<?php print (($this->config->core['site_year'] <> $year?"-{$year}":"")) ?>
			</span>
			<a class="mx-1 site-info-link" href="/">
				<i class="copyright">©</i>
				<?php print $this->config->core['site_name'] ?>
			</a>
		</div>
		<?php foreach($data['content'] as $item){?>
			<?php $value = fx_lang($item['value']) ?>
			<div class="body mx-auto">
				<a class="menu <?php print $item['css_class'] ?>" href="<?php print fx_get_url(...fx_arr($item['link_array'])) ?>">
					<div class="sidebar-body<?php print ' ' . $data['options']['css_class_body'] ?>">
						<?php if($item['icon']){ ?><i class="icon <?php print $item['css_class_icon'] ?> <?php print $item['icon'] ?>"></i><?php } ?>
						<?php if($item['image']){ ?>
							<img title="<?php print $value ?>" alt="<?php print $value ?>" class="<?php print $item['css_class_image'] ?>" src="<?php print $item['image'] ?>">
						<?php } ?>
						<span class="ml-2"><?php print $value ?></span>
					</div>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
