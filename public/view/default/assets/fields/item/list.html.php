<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var string $value
	 */
?>
<?php $values = explode(',', $value) ?>

<?php foreach($values as $value){ ?>
	<a href="<?php print fx_make_url(array('users','index'),array($data['attributes']['name'] => $value)) ?>">
		<?php print $value ?>
	</a>
<?php } ?>
