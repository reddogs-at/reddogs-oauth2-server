<?php

namespace Reddogs\OAuth2\Server;

class ModuleConfig
{
    public function __invoke()
    {
        return [
            'doctrine' => [
                'driver' => [
                    'orm_default' => [
                        'drivers' => [
                            'Reddogs\OAuth2\Server' => 'reddogs_oauth2_server'
                        ]
                    ],
                    // @todo: configuration vollständig machen!
                    'customer_portal_entity' => [
                        'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => __DIR__ . '/Entity'
                    ]
                ],
                'reddogs_doctrine_migrations' => [
                    'reddogs_oauth2_server' => [
                        'namespace' => 'Reddogs\OAuth2\Server\Entity',
                        'directory' => dirname(__DIR__) . '/data/migrations',
                        'table_name' => 'reddogs_oauth2_server_migrations'
                    ]
                ]
            ],
        ];
    }
}