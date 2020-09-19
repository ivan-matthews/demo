<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $item */
	/** @var array $menu */

	$this->prependCSS("faq");
	$this->prependJS("faq");
?>
<div class="row justify-content-center faq-one-item mt-4 footer-line pb-4">
	<div class="col-md-12 col-sm-12 col-12 col-lg-11 col-xl-11 p-0 faq-title text-center">
		<?php print $item['f_question'] ?>
	</div>

	<?php if($menu['edit'] || $menu['delete']){ ?>
		<div class="btn-group buttons item-menu col-12 text-right d-inline-block mt-4">
			<?php if($menu['edit']){ ?>
				<a class="add-post text-success radius-0 p-1 pl-2 pr-2" href="<?php print fx_get_url('faq','edit',$item['f_id']) ?>">
					<i class="fas fa-edit"></i>
					<?php print fx_lang('faq.edit_item_value') ?>
				</a>
			<?php } ?>
			<?php if($menu['delete']){ ?>
				<a class="add-post text-danger radius-0 p-1 pl-2 pr-2" href="<?php print fx_get_url('faq','delete',$item['f_id']) ?>">
					<i class="fas fa-trash-alt"></i>
					<?php print fx_lang('faq.delete_item_value') ?>
				</a>
			<?php } ?>
		</div>
	<?php } ?>

	<div class="col-md-12 col-sm-12 col-12 col-lg-11 col-xl-11 p-0 faq-body mt-4">
		<?php print $item['f_answer'] ?>
	</div>
</div>

<?php if($item['ct_id']){ ?>
	<div class="btn-group buttons item-menu col-md-12 col-sm-12 col-12 col-lg-11 col-xl-11">
		<a class="category radius-0 p-1 pl-2 pr-2" href="<?php print fx_make_url(array('faq'),array('cat'=>$item['ct_id'])) ?>">
			<?php if($item['ct_icon']){ ?><i class="<?php print $item['ct_icon'] ?>"></i><?php } ?>
			<?php print fx_lang($item['ct_title']) ?>
		</a>
	</div>
<?php } ?>