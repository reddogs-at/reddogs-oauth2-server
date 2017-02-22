<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace ReddogsTest\Oauth2\Server;

use Reddogs\Doctrine\Test\EntityManagerAwareTestCase;
use Reddogs\OAuth2\Server\Entity\Client;
use Reddogs\OAuth2\Server\ModuleConfig;
use Zend\Expressive\ConfigManager\PhpFileProvider;
use Doctrine\ORM\EntityManager;

class ClientRepositoryTest extends EntityManagerAwareTestCase
{
    protected function setUp()
    {
        $configProviders = [
            ModuleConfig::class,
            new PhpFileProvider('testconfig/autoload/{{,*.}global,{,*.}local}.php'),
        ];
        $this->setConfigProviders($configProviders);
        parent::setUp();

//         $this->truncateEntities([
//             Client::class
//         ]);
    }

    public function testTest()
    {
        $container = $this->getContainer();
        $em = $this->getContainer()->get(EntityManager::class);

        //doctrine.connection.orm_default doctrine.configuration.orm_default
    }
}

