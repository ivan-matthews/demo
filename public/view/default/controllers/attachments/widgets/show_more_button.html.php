<?php
	/** @var \Core\Classes\View $this */
	/** @var integer $total */
	/** @var integer $limit */
	/** @var integer $offset */
	/** @var string $link */
	/** @var string $selector */
?>

<div class="btn-success-light btn show-more-button button radius-0 mt-4" onclick="attachmentsObj.showMore(this,
	'<?php print $total ?>',
	'<?php print $limit ?>',
	'<?php print $offset ?>',
	'<?php print $link ?>',
	'<?php print $selector ?>'
	)">
	<?php print fx_lang('attachments.show_more_button_value') ?>
</div>

<script>
	attachmentsObj.showMore = function(self,total,limit,offset,link,selector){
		total = parseInt(total);
		limit = parseInt(limit);
		offset = parseInt(offset);
		$.ajax({
			url: link,
			method: 'GET',
			dataType: 'frame',
			data: {
				offset: limit+offset
			},
			complete: function(response){
				let body_html =  document.createElement("div");
				body_html.innerHTML = response.responseText;

				let append_content = $(selector,body_html).html();
				$(selector,document).append(append_content);

				let show_more_button = $('.show-more-button',body_html);

				$(self,document).parent().remove();
			}
		});
	};
</script>