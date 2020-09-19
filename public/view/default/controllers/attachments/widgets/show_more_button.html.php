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
