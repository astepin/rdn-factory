<?php

return [
    'controllers' => [
        'invokables' => [
			'RdnFactory:Index' => 'RdnFactory\Controller\Index',
        ],
    ],

    'rdn_factory_plugins' => [
        'aliases' => [
			'config' => 'RdnFactory:Config',
			'controller' => 'RdnFactory:Controller',
			'form' => 'RdnFactory:Form',
			'params' => 'RdnFactory:Params',
			'service' => 'RdnFactory:Service',
			'url' => 'RdnFactory:Url',
        ],

        'invokables' => [
			'RdnFactory:Config' => 'RdnFactory\Plugin\Config',
			'RdnFactory:Controller' => 'RdnFactory\Plugin\Controller',
			'RdnFactory:Form' => 'RdnFactory\Plugin\Form',
			'RdnFactory:Params' => 'RdnFactory\Plugin\Params',
			'RdnFactory:Service' => 'RdnFactory\Plugin\Service',
			'RdnFactory:Url' => 'RdnFactory\Plugin\Url',
        ],
    ],

    'service_manager' => [
        'factories' => [
			'RdnFactory\Plugin\PluginManager' => 'RdnFactory\Factory\Plugin\PluginManager',
        ],
    ],
];
