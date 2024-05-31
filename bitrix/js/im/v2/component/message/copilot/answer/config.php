<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/copilot-answer.bundle.css',
	'js' => 'dist/copilot-answer.bundle.js',
	'rel' => [
		'ui.notification',
		'main.core',
		'im.v2.lib.parser',
		'im.v2.component.message.base',
		'ui.vue3',
		'main.core.events',
		'im.v2.const',
		'im.v2.lib.utils',
		'im.v2.application.core',
		'im.v2.component.message.elements',
	],
	'skip_core' => false,
];