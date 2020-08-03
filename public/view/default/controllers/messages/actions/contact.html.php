<?php
	use \Core\Classes\View;

	/** @var View $this */
	/** @var array $data */
	/** @var array $contacts */
	/** @var array $messages */
	/** @var array $contact */
	/** @var string $total */
	/** @var array $user */

	$this->prependCSS("{$this->theme_path}/css/messages");
	$this->prependJS("{$this->theme_path}/js/messages");
?>

<div class="m-0 mb-4 contact row justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 messages-contact row list-group p-0">

		<div class="list-group-item list-group-item-action contact-item pb-1 pt-1 radius-0">

			<div class="contact-info row ">

				<div class="col-12 contact-main-block row ml-0">

					<div class="contacts-list col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2 m-0 p-0 mt-2 d-none d-sm-none d-md-block d-lg-block d-xl-block">
						<?php foreach($contacts as $message_contact){ ?>
							<div class="contact-item mt-2<?php print(fx_equal($message_contact['mc_sender_id'],$contact['mc_sender_id'])?' active block':' in-active') ?>">
								<?php if($message_contact['total']){ ?>
									<div class="total">
										<?php print $message_contact['total'] ?>
									</div>
								<?php } ?>
								<a href="<?php print fx_get_url('messages','item',$message_contact['mc_id']) ?>">
									<div class="item-photo">
										<img src="<?php print fx_avatar($message_contact['p_small'],'small',$message_contact['u_gender']) ?>">
									</div>
									<div class="item-name">
										<?php print $message_contact['u_first_name'] ?>
									</div>
									<div class="list-group-item-text is-online<?php print fx_is_online($message_contact['u_date_log']) ?> item-date">
										<?php print fx_online_status($message_contact['u_date_log']) ?>
									</div>
								</a>
							</div>
						<?php } ?>
					</div>

					<div class="col-md-9 col-sm-12 col-12 col-lg-10 col-xl-10 messages-item-info mt-2 pb-4">
						<div class="mt-2 contact-info">
							<a href="<?php print fx_get_url('users','item',$contact['mc_sender_id']) ?>">
								<div class="item-photo row ml-0">
									<img src="<?php print fx_avatar($contact['p_micro'],'micro',$contact['u_gender']) ?>">
									<div class="list-group-item-heading info item-title mb-1 ml-2">
										<?php print fx_get_full_name($contact['u_full_name'],$contact['u_gender']) ?>
									</div>
								</div>
							</a>
						</div>
						<div class="col-12 messages-list">
							<?php foreach($messages as $message){ ?>

								<?php if(!fx_equal((int)$user,(int)$message['mc_sender_id'])){ ?>

									<div class="message-item sender-block col-12">

										<div class="message-content col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 float-left mt-2">

											<div class="user-info">

												<img class="user-avatar" src="<?php print fx_avatar($contact['p_micro'],'micro',$contact['u_gender']) ?>">

												<span class="date-add">
													<?php print fx_get_date($message['m_date_created']) ?>
												</span>
												<?php if(!$message['m_date_read']){ ?>
													<span class="new-message">
														<?php print fx_lang('messages.new_sender_message') ?>
													</span>
												<?php } ?>
											</div>

											<div class="content-info p-0 pl-1 pr-1 pb-2 pt-2 mt-3">
												<?php print $message['m_content'] ?><div class="message-manage-links">
													<a class="text-danger" href="<?php print fx_get_url('messages','delete',$message['m_id']) ?>">
														<i class="fas fa-times"></i>
														<?php print fx_lang('messages.delete_message_link') ?>
													</a>
												</div>
											</div>
										</div>

									</div>

								<?php }else{ ?>

									<div class="message-item user-block col-12">

										<div class="message-content col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 float-right mt-2">

											<div class="date-add float-right">
												<?php if(!$message['m_date_read']){ ?>
													<span class="new-message">
														<?php print fx_lang('messages.new_user_message') ?>
													</span>
												<?php } ?>
												<span class="me">
													<?php print fx_lang('messages.message_my_identifier_value') ?>,
												</span>
												<span class="date">
													<?php print fx_get_date($message['m_date_created']) ?>
												</span>
											</div>

											<div class="content-info p-0 pl-1 pr-1 pb-2 pt-2 float-left col-12 mt-3">
												<?php print $message['m_content'] ?>
												<div class="message-manage-links">
													<a class="text-danger" href="<?php print fx_get_url('messages','delete',$message['m_id']) ?>">
														<i class="fas fa-times"></i>
														<?php print fx_lang('messages.delete_message_link') ?>
													</a>
												</div>
											</div>
										</div>

									</div>

								<?php } ?>
							<?php } ?>
						</div>
					</div>

				</div>

			</div>

		</div>

	</div>
</div>