<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

return array(
	'block' => array(
		'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NAME_NEW'),
		'section' => 'menu',
		'dynamic' => false,
		'subtype' => 'menu',
		'subtype_params' => array(
			'selector' => '.landing-block-node-menu-list-item-link',
			'count' => 5,
			'source' => 'catalog',
		),
		'version' => '18.4.0', // old param for backward compatibility. Can used for old versions of module via repo. Do not delete!
	),
	'cards' => array(
		'.landing-block-node-menu-list-item' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENULISTITEMLINK'),
			'label' => array('.landing-block-node-menu-list-item-link', '.landing-block-node-menu-logo'),
			'presets' => include __DIR__ . '/presets.php',
		),
	),
	'nodes' => array(
		'.landing-block-node-menu-list-item-link' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENULISTITEMLINK'),
			'type' => 'link',
		),
		
		'.landing-block-node-menu-logo-link' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENULOGOLINK'),
			'type' => 'link',
			'group' => 'logo',
		),
		'.landing-block-node-menu-logo' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENULOGO') . ' (' . Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENU_TOP_PAGE') . ')',
			'type' => 'img',
			'group' => 'logo',
			'dimensions' => array('maxWidth' => 180, 'maxHeight' => 60),
		),
		'.landing-block-node-menu-logo-2' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENULOGO') . ' (' . Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENU_NOT_TOP_PAGE') . ')',
			'type' => 'img',
			'group' => 'logo2',
			'dimensions' => array('maxWidth' => 180, 'maxHeight' => 60),
		),
		
		'.landing-block-node-menu-logo-link-small' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENULOGOLINK_SMALL_NEW'),
			'type' => 'link',
			'group' => 'logo2',
		),
		'.landing-block-node-menu-logo-small' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENULOGO2_NEW') . ' (' . Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENU_TOP_PAGE') . ')',
			'type' => 'img',
			'dimensions' => array('maxWidth' => 180, 'maxHeight' => 60),
		),
		'.landing-block-node-menu-logo-small-2' => array(
			'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENULOGO2_NEW') . ' (' . Loc::getMessage('LANDING_BLOCK_0.MENU_1_NODES_LANDINGBLOCKNODEMENU_NOT_TOP_PAGE') . ')',
			'type' => 'img',
			'dimensions' => array('maxWidth' => 180, 'maxHeight' => 60),
		),
	),
	'style' => array(
		'block' => array(
			'type' => array('display', 'header-position'),
		),
		'nodes' => array(
			'.landing-block-node-menu-list-item-link' => array(
				'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_STYLE_LANDINGBLOCKNODEMENULISTITEMLINK'),
				'type' => ['typo-simple']
			),
			'.navbar' => array(
				'name' => Loc::getMessage('LANDING_BLOCK_0.MENU_1_STYLE_LANDINGBLOCKNODEMENULIST'),
				'type' => ['navbar-full'],
			),
			'.landing-block-node-hamburger' => [
				'name' => Loc::getMessage('LANDING_BLOCK_0_MENU_1_STYLE_LANDINGBLOCKNODEMENU_HAMB'),
				'type' => ['hamburger-size', 'hamburger-animation'],
			],
		),
	),
	'assets' => array(
		'ext' => array('landing_menu', 'landing_header'),
	),
);