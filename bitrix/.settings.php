<?php
return array (
'pull_s1' => 'BEGIN GENERATED PUSH SETTINGS. DON\'T DELETE COMMENT!!!!',
'pull' => Array(
    'value' =>  array(
        'path_to_listener' => 'http://#DOMAIN#/bitrix/sub/',
        'path_to_listener_secure' => 'https://#DOMAIN#/bitrix/sub/',
        'path_to_modern_listener' => 'http://#DOMAIN#/bitrix/sub/',
        'path_to_modern_listener_secure' => 'https://#DOMAIN#/bitrix/sub/',
        'path_to_mobile_listener' => 'http://#DOMAIN#:8893/bitrix/sub/',
        'path_to_mobile_listener_secure' => 'https://#DOMAIN#:8894/bitrix/sub/',
        'path_to_websocket' => 'ws://#DOMAIN#/bitrix/subws/',
        'path_to_websocket_secure' => 'wss://#DOMAIN#/bitrix/subws/',
        'path_to_publish' => 'http://local.btx:8895/bitrix/pub/',
        'path_to_publish_web' => 'http://#DOMAIN#/bitrix/rest/',
        'path_to_publish_web_secure' => 'https://#DOMAIN#/bitrix/rest/',
        'nginx_version' => '4',
        'nginx_command_per_hit' => '100',
        'nginx' => 'Y',
        'nginx_headers' => 'N',
        'push' => 'Y',
        'websocket' => 'Y',
        'signature_key' => 'pFZ3cOQIQMpQtvsNgF8G5LJzvSp4iXwrpyjjZlAkxFx18oxNHOgvcrCq48MZitiJ7CTipwRHV28iu1WtuUiZhdN9wQOZOLHFtIfIVe31ofJZoUXRK7G1vJFL3BQRBYCI',
        'signature_algo' => 'sha1',
        'guest' => 'N',
    ),
),
'smtp' =>
	array (
		'value' =>
		array(
			'enabled' => true,
			'debug' => true, //optional
			'log_file' => '/var/mailer.log', //optional
		),
	),
'pull_e1' => 'END GENERATED PUSH SETTINGS. DON\'T DELETE COMMENT!!!!',
  'utf_mode' =>
  array (
    'value' => true,
    'readonly' => true,
  ),
  'cache_flags' =>
  array (
    'value' =>
    array (
      'config_options' => 3600,
      'site_domain' => 3600,
    ),
    'readonly' => false,
  ),
  'cookies' =>
  array (
    'value' =>
    array (
      'secure' => false,
      'http_only' => true,
    ),
    'readonly' => false,
  ),
  'exception_handling' =>
  array (
    'value' =>
    array (
      'debug' => true,
      'handled_errors_types' => 4437,
      'exception_errors_types' => 4437,
      'ignore_silence' => false,
      'assertion_throws_exception' => true,
      'assertion_error_type' => 256,
      'log' => array (
          'settings' =>
          array (
            'file' => '/var/log/php/exceptions.log',
            'log_size' => 1000000,
        ),
      ),
    ),
    'readonly' => false,
  ),
  'crypto' => 
  array (
    'value' => 
    array (
        'crypto_key' => 'nxkhob5ssq0osgpdan8x6d0l6axiksgu',
    ),
    'readonly' => true,
  ),

  'connections' =>
  array (
    'value' =>
    array (
      'default' =>
      array (
        'className' => '\\Bitrix\\Main\\DB\\MysqliConnection',
        'host' => 'localhost',
        'database' => 'sitemanager',
        'login'    => 'bitrix0',
        'password' => 'xzrtI_CT7V0O!piOV8L6',
        'options' => 2,
      ),
    ),
    'readonly' => true,
  )
);
