<?php

	use Core\Classes\View;
	/**
	 * @var View $this
	 * @var string $restore_password_token
	 */

?>
<?php $link_prefix = "{$this->config->core['site_scheme']}://{$this->config->core['site_host']}" ?>

<tr>
	<td>
		<div style="padding:18px 18px 13px 18px;border-left:1px solid #dadee3;border-right:1px solid #dadee3;font-size:12px;color:black;">
			<h1 style="margin:2px 0 15px 0;padding:0 0 4px;border-bottom:1px solid #D8DFE6;color:#45668E;font-size:100%;text-align: center;">
				<?php print fx_lang('auth.title_restore_password') ?>
			</h1>
			<table cellspacing="0" cellpadding="0" border="0" style="color: #6f7985;width: 100%">
				<tbody>
					<tr>
						<td>
							<h4 style="text-align: center;">
								<?php print fx_lang('auth.restore_password_value',array(
									'%site_name%'	=> $this->config->core['site_name'],
									'%site_link%'	=> $link_prefix
								)) ?>
							</h4>
						</td>
					</tr>
					<tr>
						<td>
							<div>
								<strong><?php print fx_lang('auth.restore_password_link_head') ?>:</strong>
								<h4>
									<span>
										<a href="<?php print $link_prefix . fx_get_url('auth','restore_password_confirm',$restore_password_token) ?>">
											<?php print $link_prefix . fx_get_url('auth','restore_password_confirm',$restore_password_token) ?>
										</a>
									</span>
								</h4>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<hr>
								<strong><?php print fx_lang('auth.restore_password_warning') ?></strong>
							<h5>
								<?php print fx_lang('auth.restore_password_warning_description') ?>
							</h5>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</td>
</tr>