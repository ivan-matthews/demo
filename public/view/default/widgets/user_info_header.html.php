<?php
	/**
	 * @var \Core\Classes\View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	*/
//	fx_die($content);
?>


<div class="row user-info-widget row justify-content-center p-0 col-10 col-sm-10 col-md-9 col-lg-6 col-xl-5">
	<div class="body mx-auto search">
		<div class="hidden search-form col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<form action="<?php print fx_get_url('search','index') ?>" method="GET">
				<input type="text" class="form-control">
			</form>
		</div>
		<div class="btn-group search-icon">
			<a class="user-info-link" href="javascript:void(0)">
				<i class="fa fa-search" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	<div class="body mx-auto user-mail">
		<div class="btn-group">
			<a class="dropdown user-info-link" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-envelope" aria-hidden="true"></i>
				<?php if($content['notice']){ ?>
					<span class="count">
					<?php print $content['mail'] ?>
				</span>
				<?php } ?>
			</a>
			<div class="dropdown-menu dropdown-menu-right radius-0">
				...
			</div>
		</div>
	</div>
	<div class="body mx-auto user-journal">
		<div class="btn-group">
			<a class="dropdown user-info-link" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-bell" aria-hidden="true"></i>
				<?php if($content['notice']){ ?>
					<span class="count">
					<?php print $content['notice'] ?>
				</span>
				<?php } ?>
			</a>
			<div class="dropdown-menu dropdown-menu-right radius-0">
				...
			</div>
		</div>
	</div>
	<div class="body mx-auto user-menu">
		<div class="btn-group">
			<a class="dropdown user-info-link" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php fx_print_avatar($content['avatar'],'micro',$content['img_date'],$content['gender'],$content['name'],$content['name'],'avatar user-avatar') ?>
			</a>
			<div class="dropdown-menu dropdown-menu-right radius-0">
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