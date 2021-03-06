<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $total */
	/** @var array $result */
	/** @var array $query */
	/** @var array $controller */
	/** @var array $result */

	$this->prependCSS("search");
	$this->prependJS("search");
?>

<div class="search-result form row form-auth justify-content-center mb-4">

	<div class="col-md-12 col-sm-12 col-12 col-lg-11 col-xl-11 p-0 list-group search">

		<div class="mt-2 mb-2">
			<form method="GET" action="<?php print fx_get_url('search','index',$controller) ?>">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text radius-0 search-icon">
							<i class="fa fa-search" aria-hidden="true"></i>
						</div>
					</div>
					<input type="text" value="<?php print $query ?>" class="form-control" name="find" placeholder="<?php print fx_lang('search.write_to_find_placeholder') ?>">
					<div class="btn-group input-group-append">
						<button class="btn btn-success radius-0" type="submit">
							<i class="fa fa-search" aria-hidden="true"></i>
						</button>
						<?php if($query){ ?>
							<a href="<?php print fx_get_url('search','index') ?>" class="btn btn-warning radius-0">
								<i class="fas fa-times"></i>
							</a>
						<?php } ?>
					</div>
				</div>
			</form>
		</div>

		<?php foreach($result as $item){ ?>

			<div class="list-group-item list-group-item-action search-item pb-1 pt-1 radius-0">

				<div class="search-info row ">

					<a href="<?php print $item['link'] ?>" class="col-11 row ml-0">

						<div class="search-item-image d-none d-sm-block col-md-3 col-sm-3 col-3 col-lg-2 col-xl-2">
							<div class="item-photo">
								<?php print $item['image'] ?>
							</div>
							<?php if(isset($item['date'])){ ?>
								<div class="list-group-item-text item-date">
									<?php print $item['date'] ?>
								</div>
							<?php } ?>
						</div>

						<div class="col-md-7 col-sm-8 col-12 col-lg-10 col-xl-10 search-item-info">
							<div class="list-group-item-heading info item-title mt-1 mb-1">
								<?php print preg_replace_callback("#{$query}#usi",function($title){
									return "<span style=\"background:yellow\">{$title[0]}</span>";
								},fx_crop_string($item['title'])) ?>
							</div>
							<div class="list-group-item-heading info item-content mt-1 mb-1">
								<?php print preg_replace_callback("#{$query}#usi",function($description){
									return "<span style=\"background:yellow\">{$description[0]}</span>";
								},fx_crop_string($item['description'])) ?>
							</div>
							<div class="list-group-item-heading info item-link mt-1 mb-1">
								<?php print fx_make_external_url(array(trim($item['link'],'/')),array(),false) ?>
							</div>
						</div>

					</a>

				</div>

			</div>

		<?php } ?>

	</div>
</div>
