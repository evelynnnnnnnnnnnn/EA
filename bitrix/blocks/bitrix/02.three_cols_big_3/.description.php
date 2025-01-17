<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

return [
	'block' => [
		'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NAME'),
		'description' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_DESCRIPTION'),
		'section' => ['text_image', 'columns', 'about'],
	],
	'cards' => [
		'.landing-block-card-left' => [
			'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_CARDS_LANDINGBLOCKCARDLEFT'),
			'label' => ['.landing-block-node-left-img', '.landing-block-node-left-title'],
		],
	],
	'nodes' => [
		'.landing-block-node-left-img' => [
			'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NODES_LANDINGBLOCKNODELEFTIMG'),
			'type' => 'img',
			'dimensions' => ['width' => 580],
			'create2xByDefault' => false,
		],
		'.landing-block-node-left-title' => [
			'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NODES_LANDINGBLOCKNODELEFTTITLE'),
			'type' => 'text',
		],
		'.landing-block-node-left-text' => [
			'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NODES_LANDINGBLOCKNODELEFTTEXT'),
			'type' => 'text',
		],
		'.landing-block-node-center-subtitle' => [
			'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NODES_LANDINGBLOCKNODECENTERSUBTITLE'),
			'type' => 'text',
		],
		'.landing-block-node-center-title' => [
			'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NODES_LANDINGBLOCKNODECENTERTITLE'),
			'type' => 'text',
		],
		'.landing-block-node-center-text' => [
			'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NODES_LANDINGBLOCKNODECENTERTEXT'),
			'type' => 'text',
		],
		'.landing-block-node-right-img' => [
			'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NODES_LANDINGBLOCKNODERIGHTIMG'),
			'type' => 'img',
			'dimensions' => ['height' => 1080],
			'create2xByDefault' => false,
		],
	],
	'style' => [
		'block' => [
			'type' => ['block-default'],
		],
		'nodes' => [
			'.landing-block-node-left' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODELEFT'),
				'type' => 'box',
				'additional' => [
					'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODE_SLIDER'),
					'attrsType' => ['autoplay', 'autoplay-speed', 'animation', 'pause-hover', 'slides-show', 'dots'],
				]
			],
			'.landing-block-node-left-title' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODELEFTTITLE'),
				'type' => ['typo', 'animation', 'heading'],
			],
			'.landing-block-node-left-text' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODELEFTTEXT'),
				'type' => ['typo', 'animation'],
			],
			'.landing-block-node-center' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODECENTER'),
				'type' => 'box',
			],
			'.landing-block-node-center-subtitle' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODECENTERSUBTITLE'),
				'type' => ['typo', 'animation'],
			],
			'.landing-block-node-center-title' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODECENTERTITLE'),
				'type' => ['typo', 'animation'],
			],
			'.landing-block-node-center-text' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODECENTERTEXT'),
				'type' => ['typo', 'animation'],
			],
			'.landing-block-node-header' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_STYLE_LANDINGBLOCKNODEHEADER'),
				'type' => ['heading'],
			],
			'.landing-block-node-right-img' => [
				'name' => Loc::getMessage('LANDING_BLOCK_2_THREE_COLS_3_NODES_LANDINGBLOCKNODERIGHTIMG'),
				'type' => 'background-size',
			],
		],
	],
	'assets' => [
		'ext' => ['landing_carousel'],
	],
];