<?php
	/**
	 * @var \Core\Classes\View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	*/
//	fx_die($content);

	$notify_link = $content['notice'] ? fx_get_url('notify','index','unreaded') : fx_get_url('notify','index');
	$uniquid = md5(microtime().uniqid());
?>

<script>
	showSearchPanel = function(id){
		let widgets_icon = $(id + '.user-info-widget .header-bar-widget-icon');
		let search_form = $(id + '.user-info-widget .search-panel .search-form');
		let search_panel = $(id + '.user-info-widget .search-panel');
		widgets_icon.animate({
			width: [ "toggle", "swing" ],
			height: [ "swing", "swing" ],
			opacity: "toggle"
		}, 150, "linear", function(){
			search_panel.addClass('col-12 row ml-0');
			search_form.show();
		});
	};
	hideSearchPanel = function(id){
		let widgets_icon = $(id + '.user-info-widget .header-bar-widget-icon');
		let search_form = $(id + '.user-info-widget .search-panel .search-form');
		let search_panel = $(id + '.user-info-widget .search-panel');
		search_form.animate({
			width: [ "swing", "swing" ],
			height: [ "swing", "swing" ],
			opacity: "toggle"
		}, 150, "linear", function(){
			search_panel.removeClass('col-12 row ml-0');
			widgets_icon.show();
		});
	}
</script>

<div id="<?php print $uniquid ?>" class="row user-info-widget justify-content-center p-0 col col-sm-10 col-md-9 col-lg-6 col-xl-5 ml-0">
	<div class="body mx-auto search search-panel">
		<div class="search-form col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 hidden">
			<form action="<?php print fx_get_url('search','index') ?>" method="GET">
				<div class="input-group">
					<div class="input-group-prepend d-none d-sm-flex">
						<div class="input-group-text radius-0 search-icon">
							<i class="fa fa-search" aria-hidden="true"></i>
						</div>
					</div>
					<input type="text" value="<?php print $this->request->get('find') ?>" class="form-control" name="find" placeholder="<?php print fx_lang('search.write_to_find_placeholder') ?>">
					<div class="btn-group input-group-append">
						<button class="btn btn-success radius-0" type="submit">
							<i class="fa fa-search" aria-hidden="true"></i>
						</button>
						<a href="javascript:hideSearchPanel('#<?php print $uniquid ?>')" class="btn btn-warning radius-0">
							<i class="fas fa-times"></i>
						</a>
					</div>
				</div>
			</form>
		</div>
		<div class="header-bar-widget-icon btn-group search-icon">
			<a class="user-info-link" href="javascript:showSearchPanel('#<?php print $uniquid ?>')">
				<i class="fa fa-search" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	<div class="header-bar-widget-icon body mx-auto user-mail">
		<div class="btn-group">
			<a href="<?php print fx_get_url('messages','index') ?>" class="user-info-link">
				<i class="fa fa-envelope" aria-hidden="true"></i>
				<?php if($content['mail']){ ?>
					<span class="count">
						<?php print $content['mail'] ?>
					</span>
				<?php } ?>
			</a>
		</div>
	</div>
	<div class="header-bar-widget-icon body mx-auto user-journal">
		<div class="btn-group">
			<a href="<?php print $notify_link ?>" class="user-info-link">
				<i class="fa fa-bell" aria-hidden="true"></i>
				<?php if($content['notice']){ ?>
					<span class="count">
						<?php print $content['notice'] ?>
					</span>
				<?php } ?>
			</a>
		</div>
	</div>
	<div class="header-bar-widget-icon body mx-auto user-menu">
		<div class="btn-group">
			<a class="dropdown user-info-link" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php fx_print_avatar($content['avatar'],'micro',$content['img_date'],$content['gender'],$content['name'],$content['name'],'avatar user-avatar') ?>
			</a>
			<div class="dropdown-menu dropdown-menu-right radius-0 m-0 p-0">
				<a class="link dropdown-item user-info" href="<?php print fx_get_url('users','item',$content['id']) ?>">
					<?php fx_print_avatar($content['avatar'],'micro',$content['img_date'],$content['gender'],$content['name'],$content['name'],'avatar user-avatar') ?>
					<?php print fx_get_full_name($content['name'],$content['gender']) ?>
				</a>
				<div class="dropdown-divider"></div>
				<?php foreach($content['menu'] as $link){ ?>
					<a class="link dropdown-item <?php print $link['l_css_class'] ?>" href="<?php print $link['l_link_array'] ?>">
						<span class="icon">
							<i class="<?php print $link['l_icon'] ?>"></i>
						</span>
						<span class="value">
							<?php print fx_lang($link['l_value']) ?>
						</span>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>

</div>