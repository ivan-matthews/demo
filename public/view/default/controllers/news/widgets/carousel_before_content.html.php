<?php

	use Core\Classes\View;

	/**
	 * @var View $this
	 * @var array $data
	 * @var array $content
	 * @var array $options
	 */
	$this->appendCSS('news');
//	fx_die($content)
?>

<?php if($content){ ?>

	<div id="carousel-<?php print $options['wa_id'] ?>" class="carousel widget-carousel slide row col-12 p-0 m-0" data-ride="carousel">
		<div class="carousel-inner col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 p-0 m-0">
			<?php foreach($content as $index => $post){ ?>

				<?php $image = $post['poster_news_image'] ? $post['poster_news_image'] : "images/news/latest_news/big_latest_news.png" ?>

				<a href="<?php print fx_get_url('news','post',$post['nw_slug']) ?>" class="carousel-item<?php if(!$index){ ?> active<?php } ?>">
					<img class="d-block w-100" data-src="<?php print fx_get_image_src($image,$post['news_image_date'],'poster') ?>" alt="<?php print fx_crop_string($post['nw_title'],30) ?>" src="<?php print fx_get_image_src($image,$post['news_image_date'],'poster') ?>" data-holder-rendered="true">
					<div class="carousel-caption">
						<h5><?php print fx_crop_string($post['nw_title'],30) ?></h5>
						<p><?php print fx_crop_string($post['nw_title'],200) ?></p>
						<div class="justify-content-center row">
							<div class="item-link mt-2 p-2 pl-4 pr-4">
								<?php print fx_lang('news.show_item_carousel') ?>
							</div>
						</div>
					</div>
				</a>
			<?php } ?>
		</div>

		<div class="carousel-buttons col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 p-0 m-0 carousel-indicators d-none d-md-block">
			<?php foreach($content as $index => $post){ ?>
				<?php $image = $post['small_news_image'] ? $post['small_news_image'] : "images/news/latest_news/small_latest_news.png" ?>

				<div data-target="#carousel-<?php print $options['wa_id'] ?>" data-slide-to="<?php print $index ?>" class="row col-12 p-0 m-0 pb-2 pt-2 carousel-buttons-item<?php if(!$index){ ?> active<?php } ?>">
					<div class="col-4">
						<img alt="<?php print fx_crop_string($post['nw_title'],30) ?>" src="<?php print fx_get_image_src($image,$post['news_image_date'],'small') ?>">
					</div>
					<div class="col-8 p-0 m-0">
						<?php print fx_crop_string($post['nw_title'],50) ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>

<?php } ?>
