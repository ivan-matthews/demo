<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */

//	if(!$this->config->core['debug_enabled']){ return false; }
?>
<div class="footer">
	<?php if($data['options']['wa_show_title']){ ?>
		<div class="footer-title<?php print ' ' . $data['options']['wa_css_class_title'] ?>">
			<div class="title">
				<?php print fx_lang($data['options']['wa_title']) ?>
			</div>
		</div>
	<?php } ?>
	<div class="footer-body debug-menu row user-info-widget row justify-content-center">

<!--		TIME BEGIN-->
		<div class="body mx-auto">
			<span class="title"><?php print fx_lang("home.time_value") ?>:</span>
			<span class="value value-green"><?php print number_format(microtime(true)-TIME,4) ?></span>
		</div>
<!--		TIME END-->

<!--		MEMORY BEGIN-->
		<div class="body mx-auto">
			<span class="title"><?php print fx_lang("home.memory_value") ?>:</span>
			<span class="value value-green"><?php print fx_prepare_memory(memory_get_usage()) ?></span>
		</div>
<!--		MEMORY END-->

<!--		CPU BEGIN-->
		<div class="body mx-auto">
			<?php $cpu_stat_array = fx_get_cpu_stat($this->config->core['debug_cpu_stat']) ?>
			<?php if(!$cpu_stat_array){ ?>
				<span class="title"><?php print fx_lang("home.cpu_value") ?>:</span>
				<span class="value value-green"><?php print fx_get_cpu_usage() ?></span>
			<?php }else{ ?>
				<a href="javascript:void(0)" class="values modal-link" data-toggle="modal" data-target=".cpu">
					<span class="title"><?php print fx_lang("home.cpu_value") ?>:</span>
					<span class="value value-green"><?php print fx_get_cpu_usage() ?></span>
				</a>
				<div class="modal fade cpu" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<table class="table">
								<?php $total_cpu = 0 ?>
								<thead class="thead-dark">
									<tr>
										<?php foreach(explode(' ', $cpu_stat_array[2]) as $key=>$cpu_item){ ?>
											<?php $cpu_item = !$key ? "TIME" : $cpu_item ?>
											<th><?php print $cpu_item ?></th>
										<?php } ?>
									</tr>
								</thead>
								<?php unset($cpu_stat_array[0],$cpu_stat_array[1],$cpu_stat_array[2]) ?>
								<tbody>
									<?php foreach($cpu_stat_array as $cpu){ ?>
										<tr>
											<?php foreach(explode(' ', $cpu) as $count=>$item_cpu){ ?>
												<?php $total_cpu = $count == 7 ? $total_cpu+floatval($item_cpu) : $total_cpu ?>
												<td><?php print $item_cpu ?></td>
											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<script>
					$('th').click(function(){
						let table = $(this).parents('table').eq(0);
						let rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
						this.asc = !this.asc;
						if (!this.asc){rows = rows.reverse()}
						for (let i = 0; i < rows.length; i++){table.append(rows[i])}
					});
					function comparer(index) {
						return function(a, b) {
							let valA = getCellValue(a, index), valB = getCellValue(b, index);
							return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
						}
					}
					function getCellValue(row, index){ return $(row).children('td').eq(index).text() }
				</script>
				(<?php print $total_cpu ?>)
			<?php } ?>
		</div>
<!--		CPU END-->

<!--		INCLUDED FILES BEGIN-->
		<div class="body mx-auto">
			<?php $files = get_included_files() ?>
			<a href="javascript:void(0)" class="values modal-link" data-toggle="modal" data-target=".files">
				<span class="title"><?php print fx_lang("home.files_value") ?>:</span>
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
<!--		INCLUDED FILES END-->

<!--		INTERNAL DEBUG BEGIN-->
<!--		--><?php //if($this->config->core['debug_enabled']){ ?>
		<?php foreach($this->debug as $key=>$value){ ?>
			<div class="body mx-auto">
				<a href="javascript:void(0)" class="values modal-link" data-toggle="modal" data-target=".<?php print $key ?>">
					<span class="title"><?php print fx_lang("home.{$key}_value") ?>:</span>
					<span class="value value-green"><?php print count($value) ?></span>
				</a>
			</div>

			<div class="modal fade bd-example-modal-lg <?php print $key ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="accordion" id="<?php print $key ?>">
							<ol>
								<?php foreach($value as $index=>$item){ ?>
									<li class="debug-ol-li">
										<div class="clipper">
											<a href="javascript:void(0)" onclick="indexObj.debugQueryToClipper(this)">
												<i class="far fa-copy text-danger"></i>
											</a>
										</div>
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
													<pre><code class="code"><?php print $item['query'] ?></code></pre>
												</div>
												<div class="debug time <?php print ($item['time']<0.1 ? 'green' : 'red') ?>" >
													<?php print $item['time'] ?>
												</div>
											</a>

											<div id="collapse<?php print $key ?><?php print $index ?>" class="collapse collapsed-debug-menu <?php /*print (!$index ? 'show' : '')*/ ?>" aria-labelledby="heading<?php print $key ?><?php print $index ?>" data-parent="#<?php print $key ?>">
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
<!--		--><?php //} ?>
<!--		INTERNAL DEBUG END-->

	</div>
</div>

<script>

</script>
