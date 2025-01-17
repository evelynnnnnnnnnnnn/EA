<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

return array(
	'block' => array(
		'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NAME'),
		'section' => array('cover'),
		'dynamic' => false,
	),
	'cards' => array(
		'.landing-block-node-card' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODECARD'),
			'label' => array('.landing-block-node-card-title', '.landing-block-node-card-subtitle'),
		),
	),
	'nodes' => array(
		'.landing-block-node-bgimg' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODEBGIMG'),
			'type' => 'img',
			'editInStyle' => true,
			'allowInlineEdit' => false,
			'dimensions' => array('width' => 1920, 'height' => 1080),
			'create2xByDefault' => false,
			'isWrapper' => true,
		),
		'.landing-block-node-card-title' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODECARDTITLE'),
			'type' => 'text',
		),
		'.landing-block-node-card-subtitle' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODECARDSUBTITLE'),
			'type' => 'text',
		),
		'.landing-block-node-card-text' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODECARDTEXT'),
			'type' => 'text',
		),
		'.landing-block-node-title' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODETITLE'),
			'type' => 'text',
		),
		'.landing-block-node-text' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODETEXT'),
			'type' => 'text',
		),
	),
	'style' => array(
		'block' => array(
			'type' => array('block-default-background', 'animation'),
		),
		'nodes' => array(
			'.landing-block-node-card-title' => array(
				'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODECARDTITLE'),
				'type' => ['typo', 'heading'],
			),
			'.landing-block-node-card-subtitle' => array(
				'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODECARDSUBTITLE'),
				'type' => 'typo',
			),
			'.landing-block-node-card-text' => array(
				'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODECARDTEXT'),
				'type' => 'typo',
			),
			'.landing-block-node-title' => array(
				'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODETITLE'),
				'type' => ['typo', 'heading'],
			),
			'.landing-block-node-text' => array(
				'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODETEXT'),
				'type' => 'typo',
			),
			'.landing-block-node-card' => array(
				'name' => Loc::getMessage('LANDING_BLOCK_40.3.TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_LANDINGBLOCKNODECARD'),
				'type' => 'align-self',
			),
			'.landing-block-slider' => [
				'additional' => [
					'name' => Loc::getMessage('LANDING_BLOCK_40_3_TEXT_BLOCKS_CAROUSEL_WITH_BGIMG_NODES_SLIDET'),
					'attrsType' => ['autoplay', 'autoplay-speed', 'animation', 'pause-hover', 'slides-show', 'arrows', 'dots'],
				]
			],
		),
	),
	'assets' => array(
		'ext' => array('landing_carousel'),
	),
);