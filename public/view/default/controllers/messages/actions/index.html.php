<?php
	use \Core\Classes\View;

	/** @var View $this */
	/** @var array $data */
	/** @var array $contacts */
	/** @var string $total */

	$this->prependCSS("messages");
	$this->prependJS("messages");
?>

<div class="m-0 mb-4 messages-list row justify-content-center">

	<div class="col-md-12 col-sm-12 col-12 col-lg-12 col-xl-12 messages row list-group p-0">

		<?php foreach($contacts as $contact){ ?>

			<?php $im_not_writer = fx_equal($contact['m_sender_id'],$contact['u_id']) ?>

			<div class="list-group-item list-group-item-action messages-item pb-1 pt-1 radius-0<?php if($contact['total']){ ?> new<?php } ?>">

				<div class="messages-info row ">

					<a href="<?php print fx_get_url('messages','item', $contact['mc_id']) ?>" class="col-12 message-main-link row ml-0">

						<div class="messages-item-image col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2 mt-2 d-none d-sm-block">
							<div class="item-photo">
								<img src="<?php print fx_avatar($contact['p_small'],'small',$contact['u_gender']) ?>">
							</div>
							<div class="list-group-item-text is-online<?php print fx_is_online($contact['u_date_log']) ?> item-date">
								<?php print fx_online_status($contact['u_date_log']) ?>
							</div>
						</div>

						<div class="col-md-9 col-sm-9 col-12 col-lg-10 col-xl-10 messages-item-info">
							<div class="list-group-item-heading info item-title mt-1 mb-1 row ml-0">

								<?php if($contact['total']){ ?>
									<div class="total pr-2 p-0 m-0">
										<div class="total-messages bg-danger text-white text-center pl-2 pr-2">
											<?php print $contact['total'] ?>
											<span class="total-new">
												<?php print fx_lang('messages.total_new_messages_count') ?>
											</span>
										</div>
									</div>
								<?php } ?>

								<?php print fx_get_full_name($contact['u_full_name'],$contact['u_gender']) ?>
								<?php if($im_not_writer){ ?>
									<span class="description pl-2">
										<?php print fx_lang('messages.user_say_value') ?>
									</span>
								<?php } ?>
							</div>
							<div class="list-group-item-heading info item-content mt-1 mb-1">
								<?php if($im_not_writer){ ?>
									<blockquote>
										<?php print str_ireplace(array("<br>","</br>","<br/>","\n"),' ',fx_crop_string($contact['m_content'],50)) ?>
									</blockquote>
								<?php }else{ ?>
									<div class="im-writer ">
										<!--<div class="me">
											<?php /*print fx_lang("messages.message_i_send_value") */?>:
										</div>-->
										<div class="message">
											<blockquote>
												<?php print str_ireplace(array("<br>","</br>","<br/>","\n"),' ',fx_crop_string($contact['m_content'],50)) ?>
											</blockquote>
										</div>
									</div>
								<?php } ?>
							</div>
							<div class="list-group-item-heading info item-link mt-1 mb-1">
								<?php print fx_get_date($contact['m_date_created']) ?>
							</div>
						</div>

					</a>

					<div class="col col-12 text-right contact-buttons mt-2">
						<a class="bg-success btn p-0 pl-2 pr-2 m-0 text-white" href="<?php print fx_get_url('messages','delete_contact',$contact['mc_id']) ?>">
							<?php print fx_lang('messages.delete_contact_link') ?>
						</a>
					</div>
				</div>

			</div>

		<?php } ?>

	</div>
</div>