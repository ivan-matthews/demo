<?php

	use Core\Classes\View;
	use Core\Classes\Language;

	/** @var View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	$lang = Language::getInstance()->getLanguageKey();
	$data['lang'] = $lang = "{$lang}_" . mb_strtoupper($lang);

	$this->addJS("tinymce.min",'view/wysiwygs/tinymce');

//	$this->renderAsset("../wysiwygs/tinymce/kits/{$data['params']['field_type']}",$data);

	include_once "kits/{$data['params']['field_type']}.html.php";