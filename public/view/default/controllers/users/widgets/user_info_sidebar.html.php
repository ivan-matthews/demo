<?php
	/**
	 * @var \Core\Classes\View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	*/
//	fx_die($content);

	$notify_link = $content['notice'] ? fx_get_url('notify','index','unreaded') : fx_get_url('notify','index');
?>

<?php if($data['options']['wa_show_title']){ ?>
	<div class="sidebar-title<?php print ' ' . $data['options']['wa_css_class_title'] ?>">
		<div class="title">
			<?php print fx_lang($data['options']['wa_title']) ?>
		</div>
	</div>
<?php } ?>

<ul class="user-info-widget list-group list-group-flush sidebar ">
	<li class="user-info-item user-link list-group-item">
		<a class="menu menu-link link user-info" href="<?php print fx_get_url('users','item',$content['id']) ?>">
			<div class="sidebar-body row name-and-avatar">
				<?php fx_print_avatar($content['avatar'],'micro',$content['img_date'],$content['gender'],$content['name'],$content['name'],'avatar user-avatar') ?>
				<span class="name pl-2">
					<?php print fx_get_full_name($content['name'],$content['gender']) ?>
				</span>
<!--				<span class="icon-logged --><?php //print(fx_is_online($content['date_log']) ? 'online' : 'offline') ?><!--">-->
<!--					--><?php //print fx_get_icon_logged($content['log_type']) ?>
<!--				</span>-->
			</div>
		</a>
	</li>

	<div class="user-info-item search search-panel list-group">
		<form action="<?php print fx_get_url('search','index') ?>" method="GET">
			<div class="input-group radius-0 p-2 bg-white">
				<input type="text" value="<?php print $this->request->get('find') ?>" class="radius-0 form-control" name="find" placeholder="<?php print fx_lang('search.write_to_find_placeholder') ?>">
				<div class="btn-group input-group-append">
					<button class="btn btn-default radius-0" type="submit">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</div>
			</div>
		</form>
	</div>

	<li class="user-info-item header-bar-widget-icon user-mail list-group-item">
		<a href="<?php print fx_get_url('messages','index') ?>" class="menu menu-link user-info-link">
			<div class="sidebar-body">
				<i class="fa fa-envelope" aria-hidden="true"></i>
				<span class="messages pl-2">
						<?php print fx_lang('messages.messages_contacts_title') ?>
					</span>
				<?php if($content['mail']){ ?>
					<span class="count float-right bg-danger text-white pl-2 pr-2">
							<?php print $content['mail'] ?>
						</span>
				<?php } ?>
			</div>
		</a>
	</li>

	<li class="user-info-item header-bar-widget-icon user-journal list-group-item">
		<a href="<?php print $notify_link ?>" class="menu menu-link user-info-link">
			<div class="sidebar-body">
				<i class="fa fa-bell" aria-hidden="true"></i>
				<span class="notify pl-2">
						<?php print fx_lang('notify.notices_title') ?>
				</span>
				<?php if($content['notice']){ ?>
					<span class="count float-right bg-danger text-white pl-2 pr-2">
						<?php print $content['notice'] ?>
					</span>
				<?php } ?>
			</div>
		</a>
	</li>
	<?php foreach($content['menu'] as $link){ ?>
		<li class="user-info-item header-bar-widget-icon user-menu list-group-item">
			<a class="menu menu-link <?php print $link['l_css_class'] ?>" href="<?php print $link['l_link_array'] ?>">
				<div class="sidebar-body">
					<span class="icon">
						<i class="<?php print $link['l_icon'] ?>"></i>
					</span>
						<span class="value pl-2">
						<?php print fx_lang($link['l_value']) ?>
					</span>
				</div>
			</a>
		</li>
	<?php } ?>


</ul>