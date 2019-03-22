<?php

$config['rpc'] = [
    'vue-admin' => [
        'servers' => [
            ['host' => $_SERVER['SERVER_NAME'], 'port' => $_SERVER['SERVER_PORT']],
        ],
        'ctimeout' => 50, // 连接超时 单位ms
        'rtimeout' => 200, // 读超时 单位ms
        'functions' => [
            // 'test' => ['app' => 'admin', 'class' => 'test_service', 'method' => 'test'],
        ],
    ],
];
