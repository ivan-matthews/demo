<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
?>
<div class="footer">
	<?php if($data['options']['show_title']){ ?>
		<div class="footer-title<?php print ' ' . $data['options']['css_class_title'] ?>">
			<div class="title">
				<?php print fx_lang($data['options']['title']) ?>
			</div>
		</div>
	<?php } ?>
	<div class="footer-body debug-menu">
		<div class="body mx-auto">
			<span class="title">Time:</span>
			<span class="value value-green"><?php print number_format(microtime(true)-TIME,4) ?></span>
		</div>
		<div class="body mx-auto">
			<span class="title">Memory:</span>
			<span class="value value-green"><?php print fx_prepare_memory(memory_get_usage()) ?></span>
		</div>
		<div class="body mx-auto">
			<span class="title">CPU:</span>
			<span class="value value-green"><?php print fx_get_cpu_usage() ?></span>
		</div>
		<div class="body mx-auto">
			<?php $files = get_included_files() ?>
			<a href="javascript:void(0)" class="values modal-link" data-toggle="modal" data-target=".files">
				<span class="title">Files:</span>
				<span class="value value-green"><?php print count($files) ?></span>
			</a>
			<div class="modal fade files" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<ol>
							<?php foreach($files as $file){ ?>
								<li>
									<div class="debug files" >
										<?php print $file ?>
									</div>
								</li>
							<?php } ?>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<?php if($this->config->core['debug_enabled']){ ?>
		<?php foreach($this->debug as $key=>$value){ ?>
			<div class="body mx-auto">
				<a href="javascript:void(0)" class="values modal-link" data-toggle="modal" data-target=".<?php print $key ?>">
					<span class="title"><?php print ucfirst($key) ?>:</span>
					<span class="value value-green"><?php print count($value) ?></span>
				</a>
			</div>

			<div class="modal fade bd-example-modal-lg <?php print $key ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="accordion" id="<?php print $key ?>">
							<ol>
								<?php foreach($value as $index=>$item){ ?>
									<li>
										<div class="card">
											<a href="javascript:void(0)" class="card-header" id="heading<?php print $key ?><?php print $index ?>" data-toggle="collapse" data-target="#collapse<?php print $key ?><?php print $index ?>" aria-expanded="true" aria-controls="collapse<?php print $key ?><?php print $index ?>">

												<div class="debug file" >
													<?php print $item['file'] ?>,
													<?php print $item['line'] ?>
												</div>
												<div class="debug query" >
													<?php print $item['class'] ?>
													<?php print $item['type'] ?>
													<?php print $item['function'] ?>(<?php print fx_implode(', ',$item['args']) ?>)
												</div>
												<div class="debug link" >
													<?php print $item['query'] ?>
												</div>
												<div class="debug time <?php print ($item['time']<0.1 ? 'green' : 'red') ?>" >
													<?php print $item['time'] ?>
												</div>
											</a>

											<div id="collapse<?php print $key ?><?php print $index ?>" class="collapse collapsed-debug-menu <?php print (!$index ? 'show' : '') ?>" aria-labelledby="heading<?php print $key ?><?php print $index ?>" data-parent="#<?php print $key ?>">
												<div class="card-body back-trace">
													<ol>
														<?php foreach($item['trace'] as $i=>$trace){ ?>
															<li>
																<div class="backtrace">
																	<div class="debug file" >
																		<?php print (isset($trace['file']) ? $trace['file'] : 'FILE') ?>,
																		<?php print (isset($trace['line']) ? $trace['line'] : 'LINE') ?>
																	</div>
																	<div class="debug query" >
																		<?php print (isset($trace['class']) ? $trace['class'] : 'CLASS') ?>
																		<?php print (isset($trace['type']) ? $trace['type'] : 'TYPE') ?>
																		<?php print (isset($trace['function']) ? $trace['function'] : 'FUNCTION') ?>
																		(<?php print fx_implode(', ',$trace['args']) ?>)
																	</div>
																</div>
															</li>
														<?php } ?>
													</ol>
												</div>
											</div>
										</div>
									</li>
								<?php } ?>
							</ol>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php } ?>
	</div>
</div>
