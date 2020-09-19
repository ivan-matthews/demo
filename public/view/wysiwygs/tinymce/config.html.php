<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$lang = \Core\Classes\Language::getInstance()->getLanguageKey();
	$data['lang'] = $lang = "{$lang}_" . mb_strtoupper($lang);

	$this->addJS('view/wysiwygs/tinymce/tinymce.min');
//	$this->renderAsset("../wysiwygs/tinymce/kits/{$data['params']['field_type']}",$data);
	include_once "kits/{$data['params']['field_type']}.html.php";