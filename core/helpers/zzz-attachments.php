<?php

	use Core\Classes\View;

	if(!function_exists('fx_count_attachments')){
		function fx_count_attachments(array $attachments){
			$result = '<div class="total-attachments">';
			foreach($attachments as $key=>$attachment){
				$result .= fx_lang("attachments.{$key}_total_count",array(
					'%total%'	=> count($attachment)
				));
			}
			$result .= "</div>";
			return $result;
		}
	}

	if(!function_exists('fx_count_all_attachments')){
		function fx_count_all_attachments(array $attachments){
			$total = 0;
			foreach($attachments as $key=>$attachment){
				$total += count($attachment);
			}
			$result = "<div class=\"total-attachments\">" . fx_lang("attachments.all_total_count",array(
					'%total%'	=> $total
				)) . "</div>";
			return $result;
		}
	}

	if(!function_exists('fx_render_attachments')){
		function fx_render_attachments(array $attachments,$position="body"){
			if(!$attachments){ return null; }
			$view = View::getInstance();
			return $view->renderAsset("controllers/attachments/widgets/list_{$position}",$attachments);
		}
	}