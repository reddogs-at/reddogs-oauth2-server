<?php

use Zend\Expressive\ConfigManager\ConfigManager;
use Reddogs\OAuth2\Server\ModuleConfig;
use Zend\Expressive\ConfigManager\PhpFileProvider;

$configManager = new ConfigManager([
    ModuleConfig::class,
    new PhpFileProvider('config/autoload/{{,*.}testing}.php')
]);

return new ArrayObject($configManager->getMergedConfig());