<?php

	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var string $link */

	$decoded_url = urldecode($link);
	$decoded_link =  "<span class=\"text-info\">{$decoded_url}</span>";
	$self_link = "<a href=\"{$this->config->core['site_scheme']}://{$this->config->core['site_host']}\">{$this->config->core['site_name']}</a>";
?>

<div class="row justify-content-center redirect-content mr-1 ml-1">

	<div class="card col-12 p-0 m-0 radius-0">
		<div class="card-header text-center">
			<h3><?php print fx_lang('redirect.redirect_dialog_header',array(
				'%site_name%'	=> $self_link
				)) ?></h3>
		</div>
		<div class="card-body text-center">
			<h5>
				<strong>
					<?php print fx_lang('redirect.redirect_dialog_title',array(
						'%site_name%'	=> $decoded_link
					)) ?>
				</strong>
			</h5>
		</div>
		<div class="card-body text-center">
			<h5>
				<?php print fx_lang('redirect.redirect_dialog_title_red',array(
					'%site_name%'	=> $decoded_link,
					'%n%'			=> "<strong><span class=\"redirect-timer text-success\">10</span></strong>"
				)) ?>
			</h5>
		</div>
		<div class="card-body text-center">
			<h8>
				<?php print fx_lang('redirect.redirect_dialog_title_link',array(
					'%link%'	=> "<a href=\"{$decoded_url}\" target=\"_blank\" class=\"redirect-link\">{$decoded_url}</a>",
				)) ?>
			</h8>
		</div>
		<div class="card-body text-center text-warning">
			<h3>
				<?php print fx_lang('redirect.redirect_dialog_title_warn',array(
					'%site_name%'	=> $decoded_link
				)) ?>
			</h3>
		</div>
		<div class="card-body text-center text-danger">
			<h3>
				<?php print fx_lang('redirect.redirect_dialog_title_warn1',array(
					'%site_name%'	=> $self_link
				)) ?>
			</h3>
		</div>
	</div>

</div>

<script>
	$(document).ready(function(){
		let timer_out;
		let obj = $('.redirect-timer');
		let redirect_link = $('.redirect-link');

		timer_out = setInterval(function(){
			let timer = parseInt(obj.html());
			if(timer > 0){
				obj.html(timer-1);
			}else{
				if(!redirect_link.hasClass('clicked')){
					redirect_link.addClass('clicked');
//					redirect_link[0].click();
					window.location = redirect_link.attr('href');
				}
			}
		},1000);
	});
</script>