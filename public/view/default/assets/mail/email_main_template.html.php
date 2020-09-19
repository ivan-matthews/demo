<?php

	use Core\Classes\View;
	/**
	 * @var View $this
	 */

?>
<?php $link_prefix = "{$this->config->core['site_scheme']}://{$this->config->core['site_host']}" ?>
<html>
<head>
	<title><?php print fx_lang('auth.successful_registration') ?></title>
	<style type="text/css">body, pre {
			font-family: Arial, Helvetica, sans-serif;
			word-wrap: break-word;
			word-break: keep-all;
		}

		body {
			padding: 8px;
			margin: 0;
		}

		pre {
			overflow: auto;
			white-space: pre-wrap;
		}
	</style>
</head>
<body marginwidth="0" marginheight="0" style="word-break: break-all;">
<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#F5F5F5" style="word-break: break-all">
	<tbody>
	<tr>
		<td width="15">
			<table cellspacing="0" cellpadding="0" width="15">
				<tbody>
				<tr>
					<td>
						<div style="height:0;line-height:0;font-size:0">&nbsp;</div>
					</td>
				</tr>
				</tbody>
			</table>
		</td>
		<td align="center" style="padding:15px 0;">
			<table cellspacing="0" cellpadding="0" width="600" bgcolor="#FFFFFF">
				<tbody>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" width="100%">
							<tbody>
							<tr>
								<td width="149" valign="top">
									<a href="<?php print $link_prefix ?>" style="display:block;color:#FFFFFF;font-size:14px;font-weight:bold;height:52px;line-height:52px;max-height:52px;text-decoration:none;background:#587BA7;">
										<img src="<?php print $link_prefix ?><?php $this->printUploadSiteRoot($this->config->view['site_logo']) ?>" alt="<?php print $this->config->core['site_name'] ?>" width="140" height="40" border="0" style="display:block;padding: 5px 20px;">
									</a>
								</td>
								<td width="100%" bgcolor="#587BA7" valign="top">&nbsp;</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>

				<?php print $this->mail ?>

				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" width="100%">
							<tbody>
							<tr>
								<td width="3">
									<div
										style="width:0;height:1px;max-height:1px;line-height:1px;font-size:0;border-left:1px solid #e6e7eb;border-right:1px solid #e8ebed;"></div>
									<div
										style="width:0;height:1px;max-height:1px;line-height:1px;font-size:0;border-left:1px solid #f5f5f5;border-right:1px solid #e6e7eb;"></div>
								</td>
								<td width="100%" valign="bottom">
									<div
										style="height:1px;max-height:1px;line-height:0;font-size:0;border-bottom:1px solid #dadee3;">
										&nbsp;
									</div>
								</td>
								<td width="3" align="right">
									<div
										style="width:0;height:1px;max-height:1px;line-height:1px;font-size:0;border-left:1px solid #e8ebed;border-right:1px solid #e6e7eb;"></div>
									<div
										style="width:0;height:1px;max-height:1px;line-height:1px;font-size:0;border-left:1px solid #e6e7eb;border-right:1px solid #f5f5f5;"></div>
								</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td bgcolor="#F5F5F5" align="right" style="padding:13px 0 0 0;font-size:12px;color:#888888;">
						<?php print fx_lang('auth.post_scriptum') ?>
					</td>
				</tr>

				<tr>
					<td bgcolor="#F5F5F5" align="right" style="padding:13px 0 0 0;font-size:12px;color:#888888;">
						<?php print fx_lang('auth.admins_from_love') ?>
						<a href="<?php print $link_prefix ?>"><?php print $this->config->core['site_name'] ?></a>!
						<hr>
						<?php print date('H:i:s d M, Y (e)') ?>
					</td>
				</tr>
				</tbody>
			</table>
		</td>
		<td width="15">
			<table cellspacing="0" cellpadding="0" width="15">
				<tbody>
				<tr>
					<td>
						<div style="height:0;line-height:0;font-size:0">&nbsp;</div>
					</td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
	</tbody>
</table>
</body>
</html>