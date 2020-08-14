<?php

	use Core\Classes\View;
	use Core\Classes\Session;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 */

	$session = Session::getInstance();
?>

<?php if($this->data['session_messages']){ ?>
	<div class="col-12 session-messages mr-0 ml-0 pr-0 pl-0 mb-3">
		<?php foreach($this->data['session_messages'] as $key=>$message){ ?>

			<div class="container session-message" id="session-message-id-<?php print $message['original_key'] ?>">
				<div class="row justify-content-center  bg-white">
					<div class="icon-block text-center m-auto bg-white <?php print $message['icon_block_class'] ?>">
						<?php if($message['preview_image']){ ?>
							<img src="<?php print $message['preview_image'] ?>" class="preview-image">
						<?php }else{ ?>
							<i class="<?php print $message['icon_class'] ?>" aria-hidden="true"></i>
						<?php } ?>
					</div>
					<div class="content-block col-sm-10 col-md-10 col-9 col-lg-11 col-xl-11 mr-0 ml-0 pr-0 pl-0">
						<div class="card">
							<div class="card-header pl-2 <?php print $message['header_class'] ?>">
								<div class="col-10 p-0"><?php print $message['head'] ?></div>
								<?php if($message['removable']){ ?>
									<div class="close-icon col-2">
<!--										--><?php //$message['unlink_link'] .= "?{$this->config->session['csrf_key_name']}=" . fx_csrf(); ?>
										<a href="<?php print $message['unlink_link'] ?>" title="<?php print fx_lang('home.close_button_title') ?>" class="text-danger">
											<i class="fa fa-times" aria-hidden="true"></i>
										</a>
									</div>
								<?php } ?>
							</div>
							<div class="card-body <?php print $message['value_class'] ?>">
								<?php print $message['value'] ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>