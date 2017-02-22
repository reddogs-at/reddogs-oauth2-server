<?php

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;

$config = require __DIR__ . '/config.php';

$container = new ServiceManager();
(new Config($config['dependencies']))->configureServiceManager($container);

$container->setService('config', $config);

return $container;