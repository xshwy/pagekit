<?php

use Pagekit\System\InfoHelper;

return [

    'name' => 'system/info',

    'main' => function ($app) {

        $app['info'] = function() {
            return new InfoHelper();
        };

    },

    'autoload' => [

        'Pagekit\\System\\' => 'src'

    ],

    'controllers' => [

        '@system: /system' => [
            'Pagekit\\System\\Controller\\InfoController'
        ]

    ],

    'menu' => [

        'system: info' => [
            'label'    => 'Info',
            'parent'   => 'system: system',
            'url'      => '@system/info',
            'priority' => 150
        ]

    ]

];
