<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var string $email */
?>

<div class="successful-email-resend row form-auth justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-9 col-xl-9 resend-content text-center">
		<?php print fx_lang('auth.email_resending_successful',array(
			'%email%'	=> $email
		))?>
	</div>

</div>