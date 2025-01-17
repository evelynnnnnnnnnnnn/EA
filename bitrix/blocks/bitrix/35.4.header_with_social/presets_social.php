<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Landing\Manager;
use Bitrix\Main\Localization\Loc;

$result = [
	'facebook' => [
		'name' => '<i class="fa fa-facebook"></i> Facebook',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="facebook">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://facebook.com">
					<i class="landing-block-node-social-icon fa fa-facebook"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://facebook.com',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-facebook'],
			],
		],
	],
	
	'instagram' => [
		'name' => '<i class="fa fa-instagram"></i> Instagram',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="instagram">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://instagram.com">
					<i class="landing-block-node-social-icon fa fa-instagram"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://instagram.com',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-instagram'],
			],
		],
	],

	'whatsapp' => [
		'name' => '<i class="fa fa-whatsapp"></i> WhatsApp',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="whatsapp">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://whatsapp.com/">
					<i class="landing-block-node-social-icon fa fa-whatsapp"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://whatsapp.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-whatsapp'],
			],
		],
	],

	'viber' => [
		'name' => '<i class="fab fa-viber g-pr-5"></i> Viber',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="viber">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://viber.com/">
					<i class="landing-block-node-social-icon fab fa-viber"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.viber.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fab','fa-viber'],
			],
		],
	],

	'telegram' => [
		'name' => '<i class="fa fa-telegram"></i> Telegram',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="telegram">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://telegram.org/">
					<i class="landing-block-node-social-icon fa fa-telegram"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://telegram.org/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-telegram'],
			],
		],
	],

	'facebook-messenger' => [
		'name' => '<i class="fab fa-facebook-messenger g-pr-5"></i> Facebook Messenger',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="facebook-messenger">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.messenger.com/">
					<i class="landing-block-node-social-icon fab fa-facebook-messenger"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.messenger.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fab','fa-facebook-messenger'],
			],
		],
	],

	'tiktok' => [
		'name' => '<i class="fab fa-tiktok g-pr-5"></i> TikTok',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="tiktok">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.tiktok.com/">
					<i class="landing-block-node-social-icon fab fa-tiktok"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.tiktok.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fab','fa-tiktok'],
			],
		],
	],

	'youtube' => [
		'name' => '<i class="fab fa-youtube"></i> YouTube',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="youtube">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.youtube.com/">
					<i class="landing-block-node-social-icon fab fa-youtube"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.youtube.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fab','fa-youtube'],
			],
		],
	],

	'vk' => [
		'name' => '<i class="fa fa-vk"></i> '.Loc::getMessage('LANDING_BLOCK_HEADER_35_4__SOCIALS__PRESET_VK'),
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="vk">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://vk.com">
					<i class="landing-block-node-social-icon fa fa-vk"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://vk.com',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-vk'],
			],
		],
	],

	'odnoklassniki' => [
		'name' => '<i class="fa fa-odnoklassniki"></i> '.Loc::getMessage('LANDING_BLOCK_HEADER_35_4__SOCIALS__PRESET_OK'),
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="odnoklassniki">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://odnoklassniki.com">
					<i class="landing-block-node-social-icon fa fa-odnoklassniki"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://odnoklassniki.com',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-odnoklassniki'],
			],
		],
	],

	'skype' => [
		'name' => '<i class="fa fa-skype"></i> Skype',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="skype">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://skype.com">
					<i class="landing-block-node-social-icon fa fa-skype"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://skype.com',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-skype'],
			],
		],
	],
	
	'twitter' => [
		'name' => '<i class="fa fa-twitter"></i> Twitter',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="twitter">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://twitter.com">
					<i class="landing-block-node-social-icon fa fa-twitter"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://twitter.com',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-twitter'],
			],
		],
	],

	'tumblr' => [
		'name' => '<i class="fa fa-tumblr"></i> Tumblr',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="tumblr">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.tumblr.com/">
					<i class="landing-block-node-social-icon fa fa-tumblr"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.tumblr.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-tumblr'],
			],
		],
	],

	'discord' => [
		'name' => '<i class="fab fa-discord g-pr-5"></i> Discord',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="discord">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.discord.com/">
					<i class="landing-block-node-social-icon fab fa-discord"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.discord.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fab','fa-discord'],
			],
		],
	],

	'wechat' => [
		'name' => '<i class="fa fa-weixin"></i> WeChat',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="wechat">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.wechat.com/">
					<i class="landing-block-node-social-icon fa fa-weixin"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.wechat.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-weixin'],
			],
		],
	],
	
	'pinterest' => [
		'name' => '<i class="fa fa-pinterest"></i> Pinterest',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="pinterest">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://pinterest.com">
					<i class="landing-block-node-social-icon fa fa-pinterest"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://pinterest.com',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-pinterest'],
			],
		],
	],

	'twitch' => [
		'name' => '<i class="fa fa-twitch"></i> Twitch',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="twitch">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.twitch.tv/">
					<i class="landing-block-node-social-icon fa fa-twitch"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.twitch.tv/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-twitch'],
			],
		],
	],

	'linkedin' => [
		'name' => '<i class="fa fa-linkedin"></i> LinkedIn',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="linkedin">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.linkedin.com/">
					<i class="landing-block-node-social-icon fa fa-linkedin"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.linkedin.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-linkedin'],
			],
		],
	],

	'snapchat' => [
		'name' => '<i class="fa fa-snapchat"></i> Snapchat',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="snapchat">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.snapchat.com/">
					<i class="landing-block-node-social-icon fa fa-snapchat"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.snapchat.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-snapchat'],
			],
		],
	],

	'flickr' => [
		'name' => '<i class="fa fa-flickr"></i> Flickr',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="flickr">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.flickr.com/">
					<i class="landing-block-node-social-icon fa fa-flickr"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://www.flickr.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-flickr'],
			],
		],
	],

	'soundcloud' => [
		'name' => '<i class="fa fa-soundcloud"></i> Soundcloud',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="soundcloud">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://soundcloud.com/">
					<i class="landing-block-node-social-icon fa fa-soundcloud"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://soundcloud.com/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-soundcloud'],
			],
		],
	],

	'dribbble' => [
		'name' => '<i class="fa fa-dribbble"></i> Dribbble',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="dribbble">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://dribbble.com">
					<i class="landing-block-node-social-icon fa fa-dribbble"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://dribbble.com',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fa','fa-dribbble'],
			],
		],
	],

	'rocketchat' => [
		'name' => '<i class="fab fa-rocketchat g-pr-5"></i> Rocket.chat',
		'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="rocketchat">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://rocket.chat/">
					<i class="landing-block-node-social-icon fab fa-rocketchat"></i>
				</a>
			</li>',
		'disallow' => ['.landing-block-node-social-icon'],
		'values' => [
			'.landing-block-node-social-link' => [
				'href' => 'https://rocket.chat/',
			],
			'.landing-block-node-social-icon' => [
				'type' => 'icon',
				'classList' => ['fab','fa-rocketchat'],
			],
		],
	],
];

if (Manager::getZone() === 'cn')
{
	$resultCnZone = [
		'renren' => [
			'name' => '<i class="fab fa-renren g-pr-5"></i> Renren',
			'html' => '
			<li class="landing-block-node-social-item list-inline-item g-valign-middle g-mx-3 g-mb-6"
				data-card-preset="renren">
				<a class="landing-block-node-social-link d-block u-icon-v3 u-icon-size--sm g-rounded-50x g-bg-gray-light-v4 g-color-gray-light-v1 g-bg-primary--hover g-color-white--hover g-font-size-14"
				   href="https://www.renren.com">
					<i class="landing-block-node-social-icon fab fa-renren"></i>
				</a>
			</li>',
			'disallow' => ['.landing-block-node-social-icon'],
			'values' => [
				'.landing-block-node-social-link' => [
					'href' => 'https://www.renren.com',
				],
				'.landing-block-node-social-icon' => [
					'type' => 'icon',
					'classList' => ['fab','fa-renren'],
				],
			],
		],
	];
	$result = array_merge($result, $resultCnZone);
}

if (!in_array(Manager::getZone(), ['ru', 'kz', 'by']))
{
	unset($result['vk'], $result['odnoklassniki']);
}

return $result;