<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
?>

<div class="user-avatar row justify-content-center">

	<?php fx_print_avatar(
		$user['p_normal'],
		'normal',
		$user['u_gender'],
		$user['u_full_name'],
		$user['u_full_name']
	) ?>

</div>