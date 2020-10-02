<?php

	use Core\Classes\Kernel;
	use Core\Classes\View;

	/** @var View $this */
	/** @var array $data */
	/** @var array $bids */
	/** @var string $total */

	$this->prependCSS("feedback");
	$this->prependCSS("notify");
	$this->prependJS("feedback");
	$this->prependJS("notify");
?>

<div class="row justify-content-center feedback-list">

	<div class="col-12 feedback-items">

		<?php foreach($bids as $item){ ?>

			<?php $readed = $item['fb_date_updated'] && fx_equal((int)$item['fb_status'],Kernel::STATUS_INACTIVE) ?>

			<a href="<?php print fx_get_url('feedback','requests_item',$item['fb_email']) ?>">

				<div class="list-group-item list-group-item-action bids-item pb-1 pt-1 radius-0 status-<?php print $item['fb_status'] ?>">

					<div class="bid-items-info row ">

						<div class="bid-items-item-avatar col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2 p-0 pl-2 pr-2 text-center">

							<div class="item-photo item-text-photo row justify-content-center">
								<div class="user-info">
									<div class="user-info-avatar" id="avatar"></div>
									<div class="user-info-name" id="name">
										<?php print $item['fb_name'] ?>
									</div>
								</div>
							</div>
							<div class="list-group-item-text item-date">
								<?php print fx_get_date($item['fb_date_created']) ?>
							</div>
							<?php if($readed){ ?>
								<div class="list-group-item-text item-date-readed">
									<?php print fx_lang('feedback.notice_is_readed') ?>
									<?php print fx_get_date($item['fb_date_updated']) ?>
								</div>
							<?php } ?>
						</div>

						<div class="col-md-7 col-sm-8 col-9 col-lg-10 col-xl-10 bid-items-item-info">

							<div class="col-12 item-email row">
								<?php if(!$readed){ ?>
									<div class="new bg-danger text-white pr-3 pl-3 mr-4">
										<?php print fx_lang('feedback.new_feedback_bid') ?>
									</div>
								<?php } ?>
								<?php print $item['fb_email'] ?>
								<div class="total-per-contact<?php if(!$readed){ ?> total-per-contact-new<?php } ?>">
									<?php print $item['total'] ?>
								</div>
							</div>
							<div class="col-12 item-content">
								<?php print fx_crop_string($item['fb_content'],300) ?>
							</div>

						</div>

					</div>

				</div>

			</a>
		<?php } ?>

	</div>

</div>