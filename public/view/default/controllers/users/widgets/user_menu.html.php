<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $user
	 * @var array $fields
	 * @var array $menu
	 */
?>

<div class="user-menu row justify-content-center mt-2">
	<ul class="list-group">
		<?php foreach($menu as $link_array){ ?>
			<li class="list-group-item radius-0">
				<a href="<?php print $link_array['link'] ?>" class="list-item-link <?php print $link_array['link_class'] ?>">
					<i class="<?php print $link_array['icon'] ?> <?php print $link_array['icon_class'] ?>"></i>
					<span class="text">
						<?php print $link_array['value'] ?>
					</span>
				</a>
			</li>
		<?php } ?>
	</ul>
</div>