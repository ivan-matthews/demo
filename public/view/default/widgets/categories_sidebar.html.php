<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 */
	if(!$data['content']){ return false; }
	$cat = $this->request->get('cat');
?>

<?php if($data['options']['wa_show_title']){ ?>
	<div class="categories-sidebar-title sidebar-title<?php print ' ' . $data['options']['wa_css_class_title'] ?>">
		<div class="title">
			<?php print fx_lang($data['options']['wa_title']) ?>
		</div>
	</div>
<?php } ?>
<ul class="list-group list-group-flush sidebar categories-sidebar<?php print ' ' . $data['options']['wa_css_class'] ?>">
	<?php foreach($data['content'] as $item){ ?>
		<?php $value = fx_lang($item['ct_title']) ?>
		<li class="list-group-item">
			<a class="menu" href="<?php print fx_make_url(array($item['ct_controller']),array('cat'=>$item['ct_id'])) ?>">
				<div class="sidebar-body<?php print ' ' . $data['options']['wa_css_class_body'] ?>">
					<?php if($item['ct_icon']){ ?><i class="icon <?php print $item['ct_icon'] ?>"></i><?php } ?>
					<span class="ml-2"><?php print $value ?></span>
				</div>
			</a>
		</li>
	<?php } ?>
</ul>






