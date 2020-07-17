<html>
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
</head>
<body>
<?php $preview_code = $this->makeCodePreview($this->error_file,$this->error_line) ?>
<?php $this->getErrorCodeString() ?>
<div class="header">
	<div class="err-number">
		<?php print $this->error_code_string ?>
	</div>
	<div class="err-message"><?php print $this->error_message ?></div>
	<div class="err-file-line">
		<span class="err-file"><?php print $this->error_file ?>, </span>
		<span class="err-file"><?php print $this->error_line ?></span>
	</div>
	<?php if($this->error_msg){ ?>
		<span class="err-msg"><?php print $this->error_msg ?></span>
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
					<?php $class = isset($trace['class']) ? $trace['class'] : null ?>
					<?php $type = isset($trace['type']) ? $trace['type'] : null ?>
					<?php $fnct = isset($trace['function']) ? $trace['function'] : null ?>
					<?php $file = isset($trace['file']) ? $trace['file'] : null ?>
					<?php $line = isset($trace['line']) ? $trace['line'] : null ?>
					<?php $active = fx_equal($file.$line,$this->error_file.$this->error_line) ? ' active' : '' ?>
					<tr>
						<td>
							<div class="backtrace<?php print $active ?>" onclick="openOrClosePreviewCode(this,'#id_<?php print $key ?>')">
								<div class="class">
									<span class="class-file"><?php print $class ?></span>
									<span class="class-type"><?php print $type ?></span>
									<span class="class-fnct"><?php print $fnct ?></span>
								</div>
								<div class="file">
									<span class="file-file"><?php print $file ?>, </span>
									<span class="file-line"><?php print $line ?></span>
								</div>
								<div class="delimiter"></div>
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</td>
		<td width="50%">
			<div class="code-preview-parent view" id="undefined">
				<div class="err-file-line">
					<span class="err-file"><?php print $this->error_file ?></span>
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
				<?php $class = isset($trace['class']) ? $trace['class'] : null ?>
				<?php $type = isset($trace['type']) ? $trace['type'] : null ?>
				<?php $fnct = isset($trace['function']) ? $trace['function'] : null ?>
				<?php $file = isset($trace['file']) ? $trace['file'] : null ?>
				<?php $line = isset($trace['line']) ? $trace['line'] : null ?>
				<?php $code_array = $this->makeCodePreview($file,$line) ?>
				<?php if(!$code_array){ continue; } ?>
				<div class="code-preview-parent hide" id="id_<?php print $key ?>">
					<div class="err-file-line">
						<span class="err-file"><?php print $file ?></span>
					</div>
					<div class="code-preview">
					<pre>
						<?php
							foreach($code_array as $str_key=>$str){
								if(!$str){ continue; }
								$error_line_class = fx_equal($str_key,$line) ? 'danger' : 'normal';
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



<style>
	body{
		background: lightyellow;
	}
	.header{
		display: block;
		font-size: 20px;
		max-width: 1024px;
		width: 100%;
		margin: 0 auto;
		font-weight: bold;
	}
	.header .err-number{
		font-size: 42px;
		color: red;
		padding-left: 5%;
	}
	.header .err-message{
		color: darkolivegreen;
		/*background: cadetblue;*/
		padding: 10px 0;
		padding-left: 5%;
	}
	.header .err-msg{
		font-size: 20px;
		color: white;
		background: red;
		display: block;
		padding: 10px 0;
		padding-left: 5%;
	}
	.header .err-file-line{
		margin-top:10px;
		margin-bottom:10px;
		font-size: 18px;
		padding-left: 5%;
	}
	.header .err-file-line .err-file{

	}
</style>

<style>
	.backtrace{
		cursor: pointer;
	}
	.backtrace:hover{
		background: #999999;
	}
	.backtrace:hover>.class{
		color: white;
		background: slategrey;
	}
	.backtrace:hover>.file .file-file{
		color: white;
	}
	.backtrace:hover>.file .file-line{
		color: white;
		background: red;
	}
	.backtrace.active{
		background: #999999;
	}
	.backtrace.active>.class{
		color: white;
		background: slategrey;
	}
	.backtrace.active>.file .file-file{
		color: white;
	}
	.backtrace.active>.file .file-line{
		color: white;
		background: red;
	}
	.backtrace .class{
		color: slategrey;
		font-weight: bold;
		padding: 10px 5px;
	}
	.backtrace .class .class-file{
		font-weight: bold;
	}
	.backtrace .class .class-type{}
	.backtrace .class .class-fnct{}
	.backtrace .file{
		font-weight: normal;
	}
	.backtrace .file{
		margin-bottom: 5px;
		margin-top: 5px;
		padding: 5px 5px;
	}
	.backtrace .file .file-file{
		color: #888888;
	}
	.backtrace .file .file-line{
		color: red;
		font-weight: bold;
	}
	.backtrace .delimiter{
		display: block;
		position: relative;
		border-bottom: solid 1px slategray;
		width: 100%;
		/*margin:10px 0;*/
	}
</style>

<style>
	.view{
		display: block;
	}
	.hide{
		display: none;
	}
	.code-preview{
		display: block;
		background: #f3f3f3;
		color: #6e7379;
		font-weight: bold;
		overflow-x: auto;
	}
	.code-preview pre{
		max-width: 500px;
	}
	.code-preview .normal{}
	.code-preview .normal .key{
		color: white;
		background: green;
	}
	.code-preview .normal .code{}
	.code-preview .danger{}
	.code-preview .danger .key{}
	.code-preview .danger .code{
		background: red;
		color: white;
	}
	.err-file-line{
		display: block;
		font-size: 20px;
		font-weight: bold;
	}
	.err-file-line .err-file{
		color: slategrey;
	}
	.err-file-line .err-line{
		color: darkgrey;
	}
</style>
<script>
	function openOrClosePreviewCode(self,selector){
		let selector_obj = document.querySelectorAll(".code-preview-parent" + selector);

		if(selector_obj[0] !== undefined && selector_obj[0].classList !== undefined){
			let parents = document.querySelectorAll('.code-preview-parent');
			if(parents[0] !== undefined && parents[0].classList !== undefined){
				for(let o=0;o<parents.length;o++){
					parents[o].classList.remove('view');
					parents[o].classList.add('hide');
				}
				selector_obj[0].classList.add('view');
				selector_obj[0].classList.remove('hide');

				if(self.classList !== undefined){
					let self_parents = document.querySelectorAll('.backtrace');
					if(self_parents[0] !== undefined && self_parents[0].classList !== undefined){
						for(let u=0;u<self_parents.length;u++){
							self_parents[u].classList.remove('active');
						}
						self.classList.add('active');
					}
				}
			}
		}
	}
</script>