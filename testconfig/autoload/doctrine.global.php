<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'admin',
                    'dbname'   => 'reddogs_oauth2_server',
                    'driverOptions' => [
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET utf8'
                    ]
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'Reddogs\Oauth2\Server\Entity' => 'reddogs_oauth2_server_entity',
                ],
            ],
            'reddogs_oauth2_server_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => __DIR__ . '/../../src/Entity',
            ],
        ],
    ],
];