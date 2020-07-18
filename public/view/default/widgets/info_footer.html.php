<?php
	/** @var \Core\Classes\View $this */
	$year = date('Y');
?>

<div class="footer footer-menu-info">
	<?php if($data['options']['wa_show_title']){ ?>
		<div class="footer-title<?php print ' ' . $data['options']['wa_css_class_title'] ?>">
			<div class="title">
				<?php print fx_lang($data['options']['wa_title']) ?>
			</div>
		</div>
	<?php } ?>
	<div class="footer-body">
		<div class="body mx-auto">
			<span class="site-year">
				<i class="copyright">©</i>
				<?php print $this->config->core['site_year'] ?>
				<?php print (($this->config->core['site_year'] <> $year?"- {$year}":"")) ?>
			</span>
			<a class="mx-1 site-info-link" href="/">
				<?php print $this->config->core['site_name'] ?>
			</a>
		</div>
		<?php foreach($data['content'] as $item){?>
			<?php $value = fx_lang($item['l_value']) ?>
			<div class="body mx-auto">
				<a class="menu <?php print $item['l_css_class'] ?>" href="<?php print $item['l_link_array'] ?>">
					<div class="sidebar-body<?php print ' ' . $data['options']['wa_css_class_body'] ?>">
						<?php if($item['l_icon']){ ?><i class="icon <?php print $item['l_css_class_icon'] ?> <?php print $item['l_icon'] ?>"></i><?php } ?>
						<?php if($item['l_image']){ ?>
							<img title="<?php print $value ?>" alt="<?php print $value ?>" class="<?php print $item['l_css_class_image'] ?>" src="<?php print $item['l_image'] ?>">
						<?php } ?>
						<span class="ml-2"><?php print $value ?></span>
					</div>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
