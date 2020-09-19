<?php

	use Core\Classes\Kernel;

	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $item */

	$this->prependCSS("feedback");
	$this->prependJS("feedback");

	$readed = $item['fb_date_updated'] && fx_equal((int)$item['fb_status'],Kernel::STATUS_INACTIVE)
?>

<div class="row justify-content-center feedback-item">

	<div class="col-12 feedback-item-class">

		<div class="feedback-info row col-12 pb-4 footer-line p-0 m-0">
			<div class="name col">
				<?php print fx_lang('feedback.title_feedback_name') ?>
				<div class="feedback-name">
					<?php print $item['fb_name'] ?>
				</div>
			</div>
			<div class="email col">
				<?php print fx_lang('feedback.title_feedback_email') ?>
				<div class="feedback-email">
					<?php print $item['fb_email'] ?>
				</div>
			</div>
			<div class="phone col">
				<?php print fx_lang('feedback.title_feedback_phone') ?>
				<div class="feedback-phone">
					<?php print $item['fb_phone'] ?>
				</div>
			</div>
		</div>

		<div class="feedback-question-title mt-4 ">
			<?php print fx_lang('feedback.question_title') ?>
		</div>

		<div class="feedback-question">
			<blockquote class="m-0 mb-1">
				<?php print $item['fb_content'] ?>
			</blockquote>
			<div class="row col-12 d-block text-right date">
				<?php print fx_get_date($item['fb_date_created']) ?>
			</div>
		</div>

		<?php if($item['fb_answer']){ ?>

			<div class="feedback-answer-title">
				<?php print fx_lang('feedback.answer_title') ?>
			</div>

			<div class="feedback-answer footer-line pb-4">
				<blockquote class="m-0 mb-1">
					<?php print $item['fb_answer'] ?>
				</blockquote>
				<div class="row col-12 d-block text-right date">
					<?php print fx_get_date($item['fb_date_updated']) ?>
				</div>
			</div>

		<?php } ?>

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