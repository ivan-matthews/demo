<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $contacts */
	/** @var string $title */
	/** @var string $footer */

	$this->prependCSS("feedback");
	$this->prependJS("feedback");

	$total = count($contacts);

	switch($total){
		case $total === 1:
			$div_size = 12;
			break;
		case $total === 2:
			$div_size = 6;
			break;
		case $total >= 3:
			$div_size = 4;
			break;
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

		<?php foreach($contacts as $contact){ ?>

			<div class="feedback-item col-<?php print $div_size ?>">

				<div class="region-head">
					<?php print $contact['city'] ?>
				</div>

				<div class="location">
					<div class="country">
						<?php print $contact['country'] ?>
					</div>
					<div class="region">
						<?php print $contact['region'] ?>
					</div>
					<div class="city">
						<?php print $contact['city'] ?>
						<div class="street d-flex">
							<?php print $contact['street'] ?>,
							<div class="house">
								<?php print $contact['house'] ?>,
							</div>
							<div class="apartment">
								<?php print $contact['apartment'] ?>
							</div>
						</div>
					</div>
					<div class="phones">
						<div class="phones-title mt-2 footer-line mb-1">
							<?php print fx_lang('feedback.contact_phones') ?>
						</div>
						<?php foreach($contact['phones'] as $phone){ ?>
							<div class="phone">
								<a class="phone" href="call:+<?php print $phone ?>">+<?php print $phone ?></a>
							</div>
						<?php } ?>
					</div>
					<div class="mails">
						<div class="mails-title mt-2 footer-line mb-1">
							<?php print fx_lang('feedback.contact_emails') ?>
						</div>
						<?php foreach($contact['emails'] as $email){ ?>
							<div class="mail">
								<a class="email" href="mailto:<?php print $email ?>"><?php print $email ?></a>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>

		<?php } ?>

		<div class="title-info header-line mt-4 pt-2">
			<?php print fx_lang($footer,array(
				'%link%'	=> fx_get_url('feedback','send')
			)) ?>
		</div>

	</div>

</div>