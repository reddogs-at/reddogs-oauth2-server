<?php
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;
use Doctrine\ORM\EntityManager;

return [
    'dependencies' => [
        'factories' => [
            EntityManager::class => \ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
        'aliases' => [
            'configuration' => 'config',
        ],
    ],
];
