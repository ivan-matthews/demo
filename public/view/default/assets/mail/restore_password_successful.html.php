<?php

	use Core\Classes\View;
	/**
	 * @var View $this
	 * @var string $login
	 * @var string $password
	 * @var string $bookmark
	 * @var string $id
	 */

?>
<?php $link_prefix = "{$this->config->core['site_scheme']}://{$this->config->core['site_host']}" ?>

<tr>
	<td>
		<div style="padding:18px 18px 13px 18px;border-left:1px solid #dadee3;border-right:1px solid #dadee3;font-size:12px;color:black;">
			<h1 style="margin:2px 0 15px 0;padding:0 0 4px;border-bottom:1px solid #D8DFE6;color:#45668E;font-size:100%;text-align: center;">
				<?php print fx_lang('auth.successful_registration') ?>
			</h1>
			<table cellspacing="0" cellpadding="0" border="0" style="color: #6f7985;width: 100%">
				<tbody>
				<tr>
					<td>
						<h4 style="text-align: center;">
							<?php print fx_lang('auth.thanks_for_registration',array(
								'%site_link%'	=> $link_prefix . fx_get_url('users','item',$id),
								'%site_name%'	=> $this->config->core['site_name']
							)) ?>
						</h4>
					</td>
				</tr>
				<tr>
					<td>
						<hr>
						<h5><?php print fx_lang('auth.your_auth_data_for_future') ?>:</h5>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							<div style="float: left;width: 90px;">
								<strong><?php print fx_lang('auth.login') ?>:</strong>
							</div>
							<div>
								<span style="color: #4a76a8;"><?php print $login ?></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							<div style="float: left;width: 90px;">
								<strong><?php print fx_lang('auth.password') ?>:</strong>
							</div>
							<div>
								<span style="color: #4a76a8;"><?php print $password ?></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							<div style="float: left;width: 90px;">
								<strong><?php print fx_lang('auth.bookmark') ?>:</strong>
							</div>
							<div>
								<span>
									<a href="<?php print $link_prefix . fx_get_url('auth','item',$bookmark) ?>">
										<?php print $link_prefix . fx_get_url('auth','item',$bookmark) ?>
									</a>
								</span>
							</div>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<hr>
						<strong><?php print fx_lang('auth.page_address') ?>:</strong>
						<span>
							<a href="<?php print $link_prefix . fx_get_url('users','item',$id) ?>">
								<?php print$link_prefix .  fx_get_url('users','item',$id) ?>
							</a>
						</span>
					</td>
				</tr>

				</tbody>
			</table>
		</div>
	</td>
</tr>