<?php

	use Core\Classes\Kernel;

	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $item */

	$this->prependCSS("{$this->theme_path}/css/feedback");
	$this->prependJS("{$this->theme_path}/js/feedback");

	$readed = $item['fb_date_updated'] && fx_equal((int)$item['fb_status'],Kernel::STATUS_INACTIVE)
?>

<div class="row justify-content-center feedback-item">

	<div class="col-12 feedback-item-class">

		<div class="feedback-info row col-12 pb-4 footer-line">
			<div class="feedback-name col">
				<?php print $item['fb_name'] ?>
			</div>

			<div class="feedback-email col">
				<?php print $item['fb_email'] ?>
			</div>

			<div class="feedback-phone col">
				<?php print $item['fb_phone'] ?>
			</div>
		</div>

		<div class="feedback-content mt-4 pb-4 footer-line">
			<?php print $item['fb_content'] ?>
		</div>

		<div class="col-12 text-right mt-2">
			<a href="<?php print fx_get_url('feedback','reply',$item['fb_id']) ?>" class="mr-2 p-1">
				<i class="fas fa-reply"></i>
				<?php print fx_lang('feedback.answer_message') ?>
			</a>
			<a href="<?php print fx_get_url('feedback','delete',$item['fb_id']) ?>" class="mr-2 p-1">
				<i class="fas fa-recycle"></i>
				<?php print fx_lang('feedback.delete_message') ?>
			</a>
		</div>
	</div>

</div>