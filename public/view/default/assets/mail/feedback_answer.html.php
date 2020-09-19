<?php

	use Core\Classes\View;
	/**
	 * @var View $this
	 * @var array $item_data
	 * @var string $answer
	 */

?>
<?php $link_prefix = "{$this->config->core['site_scheme']}://{$this->config->core['site_host']}" ?>

<tr>
	<td>
		<div style="padding:18px 18px 13px 18px;border-left:1px solid #dadee3;border-right:1px solid #dadee3;font-size:12px;color:black;">
			<h1 style="margin:2px 0 15px 0;padding:0 0 4px;border-bottom:1px solid #D8DFE6;color:#45668E;font-size:100%;text-align: center;">
				<?php print fx_lang('feedback.feedback_answer',array(
					'%user_name%'	=> $item_data['fb_name']
				)) ?>
			</h1>
			<h1 style="margin:2px 0 15px 0;padding:0 0 4px;border-bottom:1px solid #D8DFE6;color:#45668E;font-size:100%;text-align: center;">
				<?php print fx_lang('feedback.recently_asked',array(
					'%site_name%'	=> $this->config->core['site_name'],
					'%site_link%'	=> $link_prefix,
				)) ?>
				<blockquote style="color:#9c6868;padding: 8px 10px;margin-top: 4px;font-style: italic;border: solid 1px rgba(0, 0, 0, 0.125);border-left: solid 5px rgba(0, 0, 0, 0.125);">
					<?php print fx_crop_string($item_data['fb_content'],300) ?>
				</blockquote>
			</h1>
			<?php print fx_lang('feedback.we_answer_to_you') ?>
			<table cellspacing="0" cellpadding="0" border="0" style="color: #6f7985;width: 100%">
				<tbody>
					<tr>
						<td>
							<h6 style="padding: 8px 10px;margin-top: 4px;font-style: italic;border: solid 1px rgba(0, 0, 0, 0.125);border-left: solid 5px rgba(0, 0, 0, 0.125);">
								<?php print $answer ?>
							</h6>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</td>
</tr>