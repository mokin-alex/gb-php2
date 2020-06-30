<?php
return [
    'rootDir' => __DIR__ . "/../",
    'viewsDir' => __DIR__ . "/../views/",
    'defaultController' => 'product',
    'controllerNamespace' => 'app\controllers\\',
    'components' => [
        'connection' => [
            'class' => \app\services\Db::class,
            'driver' => 'mysql',
            'host' => 'localhost',
            'login' => 'root',
            'password' => 'root',
            'database' => 'june',
            'charset' => 'utf8',
        ],
        'request' => [
            'class' => \app\services\Request::class,
        ],
        'session' => [
            'class' => \app\services\Session::class
        ],
        'renderer' => [
            'class' => \app\services\renderers\TemplateRenderer::class
        ]
    ]
];