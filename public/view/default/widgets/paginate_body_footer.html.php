<?php
	/**
	 * @var array $content
	 */
	$content['offset'] = (int)$content['offset'];
?>
<?php $current = (int)floor($content['offset']/$content['limit']) ?>
<?php if($content['total']-$content['limit'] > $content['limit']){
	$last = $content['total']-$content['limit'];
}else{
	$last = $content['limit'];
} ?>

<nav aria-label="Page navigation example" class="paginate">
	<ul class="pagination justify-content-center">
		<li class="page-item">
			<a class="page-link<?php print (!$content['offset']?' bg-default':'') ?>" href="<?php print fx_make_url($content['link'],array(),false) ?>" aria-label="Previous">
				<span aria-hidden="true"><?php print fx_lang('home.paginate_first_page') ?></span>
			</a>
		</li>
		<?php for($i=-1;$i<6;$i++){ ?>
			<?php if($i<=0){ continue; } ?>
			<?php if(!$current){ ?>
				<?php $new_offset = $content['offset']+$content['limit']*($i) ?>
				<li class="page-item<?php print ($content['total'] < $new_offset?' disabled':'') ?>">
					<?php if(!fx_equal($new_offset,$content['offset'])){ ?>
						<a class="page-link" href="<?php print fx_make_url($content['link'],array('offset'=>$new_offset)) ?>">
							<?php print $current+$i+1 ?>
						</a>
					<?php }else{ ?>
						<a class="page-link bg-default">
							<?php print $current+$i+1 ?>
						</a>
					<?php } ?>
				</li>
			<?php } ?>

			<?php if(fx_equal($current,1)){ ?>
				<?php $new_offset = $content['offset']+$content['limit']*($i-1) ?>
				<li class="page-item<?php print ($content['total'] < $new_offset?' disabled':'') ?>">
					<?php if(!fx_equal($new_offset,$content['offset'])){ ?>
						<a class="page-link" href="<?php print fx_make_url($content['link'],array('offset'=>$new_offset)) ?>">
							<?php print $current+($i) ?>
						</a>
					<?php }else{ ?>
						<a class="page-link bg-default">
							<?php print $current+($i) ?>
						</a>
					<?php } ?>
				</li>
			<?php } ?>

			<?php if(fx_equal($current,2)){ ?>
				<?php $new_offset = $content['offset']+$content['limit']*($i-2) ?>
				<li class="page-item<?php print ($content['total'] < $new_offset?' disabled':'') ?>">
					<?php if(!fx_equal($new_offset,$content['offset'])){ ?>
						<a class="page-link" href="<?php print fx_make_url($content['link'],array('offset'=>$new_offset)) ?>">
							<?php print $current+($i-1) ?>
						</a>
					<?php }else{ ?>
						<a class="page-link bg-default">
							<?php print $current+($i-1) ?>
						</a>
					<?php } ?>
				</li>
			<?php } ?>

			<?php if($current>2){ ?>
				<?php $new_offset = $content['offset']+$content['limit']*($i-3) ?>
				<li class="page-item<?php print ($content['total'] < $new_offset?' disabled':'') ?>">
					<?php if(!fx_equal($new_offset,$content['offset'])){ ?>
						<a class="page-link" href="<?php print fx_make_url($content['link'],array('offset'=>$new_offset)) ?>">
							<?php print $current+($i-2) ?>
						</a>
					<?php }else{ ?>
						<a class="page-link bg-default">
							<?php print $current+($i-2) ?>
						</a>
					<?php } ?>
				</li>
			<?php } ?>
		<?php } ?>

		<li class="page-item<?php print ($last <= $content['offset']?' disabled':'') ?>">
			<a class="page-link" href="<?php print fx_make_url($content['link'],array('offset'=>$last)) ?>" aria-label="Next">
				<span aria-hidden="true"><?php print fx_lang('home.paginate_last_page',array('LAST'=>ceil($content['total']/$content['limit']))) ?></span>
			</a>
		</li>
	</ul>
</nav>