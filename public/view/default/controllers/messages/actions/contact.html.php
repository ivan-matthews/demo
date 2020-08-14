<?php
	use \Core\Classes\View;

	/** @var View $this */
	/** @var array $data */
	/** @var array $contacts */
	/** @var array $messages */
	/** @var array $contact */
	/** @var string $total */
	/** @var array $user */
	/** @var array $form_data */

	$this->prependCSS("{$this->theme_path}/css/messages");
	$this->prependJS("{$this->theme_path}/js/messages");

?>

<div class="m-0 mb-4 contact row justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 messages-contact row list-group p-0">

		<div class="list-group-item list-group-item-action contact-item pb-1 pt-1 radius-0">

			<div class="contact-info row ">

				<div class="col-12 contact-main-block row ml-0">

					<div class="contacts-list col-md-2 col-sm-3 col-3 col-lg-2 col-xl-2 m-0 p-0 mt-2 d-none d-sm-none d-md-block d-lg-block d-xl-block">
						<?php foreach($contacts as $message_contact){ ?>
							<div class="contact-item <?php print(fx_equal($message_contact['u_id'],$contact['u_id'])?' active block':' in-active') ?>">
								<?php if($message_contact['total']){ ?>
									<div class="total">
										<?php print $message_contact['total'] ?>
									</div>
								<?php } ?>
								<a href="<?php print fx_get_url('messages','item',$message_contact['mc_id']) ?>">
									<div class="item-photo pt-2">
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

					<div class="col-md-10 col-sm-12 col-12 col-lg-10 col-xl-10 messages-item-info mt-2 pb-4">
						<div class="mt-2 contact-info row col-12 pl-0 pr-0 ml-0 mr-0">
							<a class="col-10 link" href="<?php print fx_get_url('users','item',$contact['u_id']) ?>">
								<div class="item-photo row ml-0 col">
									<img src="<?php print fx_avatar($contact['p_micro'],'micro',$contact['u_gender']) ?>">
									<div class="list-group-item-heading info item-title mb-1 ml-2">
										<?php print fx_get_full_name($contact['u_full_name'],$contact['u_gender']) ?>
									</div>
								</div>
							</a>
							<div class="total col-2">
								<span class="title">
									<?php print fx_lang('messages.total_messages_count') ?>
								</span>
								<span class="total-messages">
									<?php print $total ?>
								</span>
							</div>

							<div class="send-form col-12">
								<?php print $this->renderForm($form_data) ?>
							</div>

						</div>
						<div class="col-12 messages-list">

							<?php foreach($messages as $message){ ?>

								<?php if(fx_equal($user['u_id'],$message['m_receiver_id'])){ ?>

									<div class="message-item sender-block col-12 float-left col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 mt-2">

										<div class="message-content">

											<div class="user-info ml-1">

												<a class="user-avatar-link" href="<?php print fx_get_url('users','item',$contact['u_id']) ?>">
													<img class="user-avatar" src="<?php print fx_avatar($contact['p_micro'],'micro',$contact['u_gender']) ?>">
													<span class="contact-name">
														<?php print $contact['u_first_name'] ?>,
													</span>
												</a>

												<span class="date-add">
													<?php print fx_get_date($message['m_date_created']) ?>
												</span>
												<?php if(!$message['m_readed']){ ?>
													<span class="new-message">
														<?php print fx_lang('messages.new_sender_message') ?>
													</span>
												<?php } ?>
											</div>

											<div class="content-info p-0 pl-4 pr-4 pb-2 pt-2 mt-1">
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

								<?php }else{ ?>

									<div class="message-item user-block col-12 float-right col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 mt-2">

										<div class="message-content">

											<div class="user-info text-right">

												<?php if(!$message['m_readed']){ ?>
													<i title="<?php print fx_lang('messages.new_user_message') ?>" class="text-success fas fa-check"></i>
												<?php }else{ ?>
													<i title="<?php print fx_lang('messages.new_user_message_read') ?>" class="text-success fas fa-check-double"></i>
												<?php } ?>

												<span class="date">
													<?php print fx_get_date($message['m_date_created']) ?>,
												</span>

												<a class="user-avatar-link" href="<?php print fx_get_url('users','item',$user['u_id']) ?>">
													<span class="me">
														<?php print fx_lang('messages.message_my_identifier_value') ?>
													</span>
													<img class="user-avatar" src="<?php print fx_avatar($user['p_micro'],'micro',$user['u_gender']) ?>">
												</a>

											</div>

											<div class="content-info p-0 pl-4 pr-4 pb-2 pt-2 col-12 mt-1 ml-1">
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