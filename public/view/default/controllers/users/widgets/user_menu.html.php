<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 */
?>

<div class="user-menu row justify-content-center mt-2">
	<ul class="list-group">
		<li class="list-group-item radius-0">
			<a href="/edit" class="list-item-link">
				<i class="fas fa-pen"></i>
				<span class="text">
							Edit
						</span>
			</a>
		</li>
		<li class="list-group-item radius-0">
			<a href="/edit" class="list-item-link">
				<i class="fas fa-pen"></i>
				<span class="text">
							Add to list
						</span>
			</a>
		</li>
		<li class="list-group-item radius-0">
			<a href="/edit" class="list-item-link">
				<i class="fas fa-pen"></i>
				<span class="text">
							Remove from list
						</span>
			</a>
		</li>
	</ul>
</div>