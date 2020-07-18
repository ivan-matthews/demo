<?php if($data['options']['show_title']){ ?>
	<div class="sidebar-title<?php print ' ' . $data['options']['css_class_title'] ?>">
		<div class="title">
			<?php print fx_lang($data['options']['title']) ?>
		</div>
	</div>
<?php } ?>
<ul class="list-group list-group-flush sidebar<?php print ' ' . $data['options']['css_class'] ?>">
<?php foreach($data['content'] as $item){?>
	<?php $value = fx_lang($item['value']) ?>
		<li class="list-group-item">
			<a class="menu <?php print $item['css_class'] ?>" href="<?php print $item['link_array'] ?>">
				<div class="sidebar-body<?php print ' ' . $data['options']['css_class_body'] ?>">
					<?php if($item['icon']){ ?><i class="icon <?php print $item['css_class_icon'] ?> <?php print $item['icon'] ?>"></i><?php } ?>
					<?php if($item['image']){ ?>
						<img title="<?php print $value ?>" alt="<?php print $value ?>" class="<?php print $item['css_class_image'] ?>" src="<?php print $item['image'] ?>">
					<?php } ?>
					<span class="ml-2"><?php print $value ?></span>
				</div>
			</a>
		</li>
<?php } ?>
</ul>





