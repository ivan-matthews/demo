<?php
	/** @var \Core\Classes\View $this */
	use Core\Classes\Kernel;
	$kernel = Kernel::getInstance();
?>

<?php
	if(
		!$this->config->view['breadcrumbs_on_main'] &&
		fx_equal($this->config->router['default_controller'],$kernel->getCurrentController()) &&
		fx_equal($this->config->router['default_action'],$kernel->getCurrentAction())
	){ return false; } ?>

<?php if($this->data['breadcrumb']){ ?>

	<nav aria-label="breadcrumb" class="breadcrumbs" id="top">

		<ol class="breadcrumb">

			<?php foreach($this->data['breadcrumb'] as $bread=>$crumb){ ?>

				<?php if(!$crumb['value']){ continue; } ?>

				<li class="breadcrumb-item">

					<a href="<?php print $crumb['link'] ?>">
						<div class="value">
							<i class="icon <?php print $crumb['icon'] ?>"></i>
							<?php print $crumb['value'] ?>
						</div>
					</a>

				</li>

			<?php } ?>

		</ol>

	</nav>

<?php } ?>
