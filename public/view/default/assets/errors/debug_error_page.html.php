<?php
	/**
	 * @var \Core\Classes\Error $this
	 */
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">

	<link rel="stylesheet" href="/public/view/default/css/error.css" type="text/css"/>
	<script src="/public/view/default/js/error.js" type="application/javascript"></script>
</head>
<body>
<?php $preview_code = $this->makeCodePreview($this->error_file,$this->error_line) ?>
<?php $this->getErrorCodeString() ?>
<div class="header">
	<div class="err-number">
		<?php print $this->error_code_string ?>
	</div>
	<div class="err-message"><pre><?php print $this->error_message ?></pre></div>
	<div class="err-file-line">
		<span class="err-file"><?php print $this->error_file ?></span>,
		<span class="err-file"><?php print $this->error_line ?></span>
	</div>
	<?php if($this->error_msg){ ?>
		<span class="err-msg"><code><?php print $this->error_msg ?></code></span>
	<?php } ?>
</div>
<hr>
<table width="100%">
	<thead>
	<tr>
		<th>
		</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td width="50%">
			<table>
				<tbody>
				<?php foreach($this->error_backtrace as $key=>$trace){ ?>
					<?php $active = fx_equal($trace['file'].$trace['line'],$this->error_file.$this->error_line) ? ' active' : '' ?>
					<tr>
						<td>
							<div class="backtrace<?php print $active ?>" onclick="openOrClosePreviewCode(this,'#id_<?php print $key ?>')" title="<?php print $trace['file'] ?>, <?php print $trace['line'] ?>">
								<div class="class">
									<span class="class-file"><?php print $trace['class'] ?></span>
									<span class="class-type"><?php print $trace['type'] ?></span>
									<span class="class-fnct"><?php print $trace['function'] ?></span>
									<span class="class-fnct">(</span>
									<span class="class-args"><?php print $trace['args'] ?></span>
									<span class="class-fnct">)</span>
								</div>
								<div class="file">
									<span class="file-file"><?php print basename($trace['file']) ?></span>,
									<span class="file-line"><?php print $trace['line'] ?></span>
								</div>
								<div class="delimiter"></div>
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</td>
		<td width="50%" class="code-window">
			<div class="code-preview-parent view" id="undefined" title="<?php print $this->error_file ?>, <?php print $this->error_line ?>">
				<div class="err-file-line">
					<span class="err-file"><?php print basename($this->error_file) ?></span>
				</div>
				<div class="code-preview">
				<pre>
					<?php
						foreach($preview_code as $key=>$str){
							if(!$str){ continue; }
							$error_line_class = fx_equal($key,$this->error_line) ? 'danger' : 'normal';
							print "<span class='{$error_line_class}'>
<span class='key'>{$key}</span>:<span class='code'>" . trim($str,"\r\n") . "</span></span>";
						}
					?>
				</pre>
				</div>
			</div>

			<?php foreach($this->error_backtrace as $key=>$trace){ ?>
				<?php $code_array = $this->makeCodePreview($trace['file'],$trace['line']) ?>
				<?php if(!$code_array){ continue; } ?>
				<div class="code-preview-parent hide" id="id_<?php print $key ?>" title="<?php print $trace['file'] ?>, <?php print $trace['line'] ?>">
					<div class="err-file-line">
						<span class="err-file"><?php print basename($trace['file']) ?></span>
					</div>
					<div class="code-preview">
					<pre>
						<?php
							foreach($code_array as $str_key=>$str){
								if(!$str){ continue; }
								$error_line_class = fx_equal($str_key,$trace['line']) ? 'danger' : 'normal';
								print "<span class='{$error_line_class}'>
<span class='key'>{$str_key}</span>:<span class='code'>" . trim($str,"\r\n") . "</span></span>";
							}
						?>
					</pre>
					</div>
				</div>
			<?php } ?>
		</td>
	</tr>
	</tbody>
</table>
</body>
</html>
<?php print number_format(microtime(true)-TIME,10) ?>


