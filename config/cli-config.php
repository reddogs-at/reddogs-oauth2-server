<?php

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\EntityManager;
use Reddogs\Migrations\Tools\Console\Helper\ConfigurationHelper;

$container = require 'config/container.php';
$config = $container->get('config');

return new \Symfony\Component\Console\Helper\HelperSet([
    'connection' => new ConnectionHelper(
        $container->get(EntityManager::class)->getConnection()
    ),
    'configuration' => new ConfigurationHelper(
        $container->get(EntityManager::class)->getConnection(),
        null,
        $config['doctrine']['reddogs_migrations']
    )
]);