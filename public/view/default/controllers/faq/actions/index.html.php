<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $items */
	/** @var integer $total */
	/** @var array $menu */

	$this->prependCSS("faq");
	$this->prependJS("faq");
?>

<?php if($menu['add']){ ?>
	<div class="buttons-panel col-12 text-right mb-1 mt-1">
		<div class="btn-group">
			<a class="add-post btn-success radius-0 p-2" href="<?php print fx_get_url('faq','add') ?>">
				<i class="fas fa-plus"></i>
				<?php print fx_lang('faq.create_answer_link_value') ?>
			</a>
		</div>
	</div>
<?php } ?>

<?php if(!$items){ return $this->renderEmptyPage(); } ?>

<div class="row justify-content-center faqs-list mt-4">
	<div class="col-md-12 col-sm-12 col-12 col-lg-11 col-xl-11 p-0 list-group faqs">
		<div class="accordion faqs-accordion" id="accordionExample">
			<ol>
				<?php foreach($items as $key=>$item){ ?>
					<li class="faq-list-item">
						<div class="card faq-block">
							<a href="javascript:void(0)" class="p-0 m-0 faq-btn btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php print $item['f_id'] ?>" aria-expanded="true" aria-controls="collapse<?php print $item['f_id'] ?>">
								<div class="card-header faq-head" id="heading<?php print $item['f_id'] ?>">
									<?php print $item['f_question'] ?>
								</div>
							</a>
							<div id="collapse<?php print $item['f_id'] ?>" class="faq-body collapse<?php if(!$key){ print " show"; } ?>" aria-labelledby="heading<?php print $item['f_id'] ?>" data-parent="#accordionExample">
								<div class="card-body faq-content">
									<?php print fx_crop_string($item['f_answer'],1000) ?>
								</div>
								<div class="row col-12">
									<?php if($item['ct_id']){ ?>
										<div class="btn-group buttons item-menu col">
											<a class="category radius-0 p-1 pl-2 pr-2" href="<?php print fx_make_url(array('faq'),array('cat'=>$item['ct_id'])) ?>">
												<?php if($item['ct_icon']){ ?><i class="<?php print $item['ct_icon'] ?>"></i><?php } ?>
												<?php print fx_lang($item['ct_title']) ?>
											</a>
										</div>
									<?php } ?>

									<div class="pt-1 col">
										<?php print fx_count_all_attachments(fx_arr($item['f_attachments_ids'])) ?>
									</div>
									<a class="view-post text-default radius-0 pt-1 col" href="<?php print fx_get_url('faq','item',$item['f_id']) ?>">
										<i class="fas fa-info-circle"></i>
										<?php print fx_lang('faq.show_item_value') ?>
									</a>
									<?php if($menu['edit']){ ?>
										<a class="add-post text-success radius-0 pt-1 col" href="<?php print fx_get_url('faq','edit',$item['f_id']) ?>">
											<i class="fas fa-edit"></i>
											<?php print fx_lang('faq.edit_item_value') ?>
										</a>
									<?php } ?>
									<?php if($menu['delete']){ ?>
										<a class="add-post text-danger radius-0 pt-1 col" href="<?php print fx_get_url('faq','delete',$item['f_id']) ?>">
											<i class="fas fa-trash-alt"></i>
											<?php print fx_lang('faq.delete_item_value') ?>
										</a>
									<?php } ?>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
			</ol>
		</div>

	</div>
</div>