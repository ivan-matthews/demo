<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $contacts */
	/** @var string $title */
	/** @var string $footer */

	$this->prependCSS("feedback");
	$this->prependJS("feedback");

	$total = count($contacts);

	$lang = $this->language->getLanguageKey();

	switch($total){
		case $total === 1:
			$div_size = 12;
			break;
		case $total >= 2:
			$div_size = 6;
			break;
		/*case $total >= 3:
			$div_size = 4;
			break;*/
		default:
			$div_size = 12;
			break;
	}
?>

<div class="row justify-content-center feedback-contacts">

	<div class="col-12 col-sm-12 col-md-12 col-xl-11 col-lg-11 feedback row">

		<div class="title-info footer-line mb-2 pb-2">
			<?php print fx_lang($title) ?>
		</div>

		<?php foreach($contacts as $items){ ?>
			<div class="feedback-item footer-line pb-4 pt-2 col-<?php print $div_size ?>">

				<div class="region-head">
					<?php print $items[0]["gc_title_{$lang}"] ?>
				</div>

				<div class="location">
					<div class="country">
						<?php print $items[0]["gc_title_{$lang}"] ?>
					</div>
					<div class="region">
						<?php print $items[0]["gr_title_{$lang}"] ?>
					</div>
					<div class="city">
						<?php print $items[0]["g_title_{$lang}"] ?>
						<div class="street d-flex">
							<?php print $items[0]['fc_street'] ?>,
							<div class="house">
								<?php print $items[0]['fc_house'] ?>,
							</div>
							<div class="apartment">
								<?php print $items[0]['fc_apartments'] ?>
							</div>
						</div>
					</div>
					<div class="contacts mt-2">
						<?php print fx_lang('feedback.contacts_index_title') ?>
					</div>
					<?php foreach($items as $contact){ ?>
						<div class="feedback-contacts-block mt-2 pt-2">

							<?php if($contact['fc_title']){ ?>
								<div class="title">
									<?php print $contact['fc_title'] ?>
								</div>
							<?php } ?>

							<?php if($contact['u_full_name']){ ?>
								<div class="operator row pt-2 header-line mb-2">
									<div class="col-2">
										<img src="<?php print fx_avatar($contact['p_micro'],'micro',$contact['u_gender']) ?>">
									</div>
									<div class="col-10">
										<?php print $contact['u_full_name'] ?>
									</div>
								</div>
							<?php } ?>

							<?php if($contact['u_phone']){ ?>
								<div class="col-12">
									<a title="<?php print fx_lang('feedback.phone_title') ?>" href="call:<?php print $contact['u_phone'] ?>">
										<div class="col-12 p-1">
											<i class="fas fa-phone-alt"></i>
											<?php print $contact['u_phone'] ?>
										</div>
									</a>
								</div>
							<?php } ?>
							<?php if($contact['u_cophone']){ ?>
								<div class="col-12">
									<a title="<?php print fx_lang('feedback.phone_title') ?>" href="call:<?php print $contact['u_cophone'] ?>">
										<div class="col-12 p-1">
											<i class="fas fa-phone-alt"></i>
											<?php print $contact['u_cophone'] ?>
										</div>
									</a>
								</div>
							<?php } ?>
							<?php if($contact['u_email']){ ?>
								<div class="col-12">
									<a title="<?php print fx_lang('feedback.email_title') ?>" href="mailto:<?php print $contact['u_email'] ?>">
										<div class="col-12 p-1">
											<i class="fas fa-at"></i>
											<?php print $contact['u_email'] ?>
										</div>
									</a>
								</div>
							<?php } ?>
							<?php if($contact['u_whatsapp']){ ?>
								<div class="col-12">
									<a title="<?php print fx_lang('feedback.whatsapp_title') ?>" href="whatsapp:<?php print $contact['u_whatsapp'] ?>">
										<div class="col-12 p-1">
											<i class="fab fa-whatsapp"></i>
											<?php print $contact['u_whatsapp'] ?>
										</div>
									</a>
								</div>
							<?php } ?>
							<?php if($contact['u_viber']){ ?>
								<div class="col-12">
									<a title="<?php print fx_lang('feedback.viber_title') ?>" href="viber:<?php print $contact['u_viber'] ?>">
										<div class="col-12 p-1">
											<i class="fab fa-viber"></i>
											<?php print $contact['u_viber'] ?>
										</div>
									</a>
								</div>
							<?php } ?>
							<?php if($contact['u_telegram']){ ?>
								<div class="col-12">
									<a title="<?php print fx_lang('feedback.telegram_title') ?>" href="telegram:<?php print $contact['u_telegram'] ?>">
										<div class="col-12 p-1">
											<i class="fab fa-telegram"></i>
											<?php print $contact['u_telegram'] ?>
										</div>
									</a>
								</div>
							<?php } ?>
							<?php if($contact['u_skype']){ ?>
								<div class="col-12">
									<a title="<?php print fx_lang('feedback.skype_title') ?>" href="skype:<?php print $contact['u_skype'] ?>">
										<div class="col-12 p-1">
											<i class="fab fa-skype"></i>
											<?php print $contact['u_skype'] ?>
										</div>
									</a>
								</div>
							<?php } ?>
							<?php if($contact['u_icq']){ ?>
								<div class="col-12">
									<a title="<?php print fx_lang('feedback.icq_title') ?>" href="icq:<?php print $contact['u_icq'] ?>">
										<div class="col-12 p-1">
											<i class="fas fa-icq"></i>
											<?php print $contact['u_icq'] ?>
										</div>
									</a>
								</div>
							<?php } ?>
							<?php if($contact['fc_description']){ ?>
								<div class="description">
									<?php print $contact['fc_description'] ?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>

			</div>

		<?php } ?>

		<div class="title-info mt-4 pt-2">
			<?php print fx_lang($footer,array(
				'%link%'	=> fx_get_url('feedback','send')
			)) ?>
		</div>

	</div>

</div>