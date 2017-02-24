<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace ReddogsTest\OAuth2\Server\Repository;

use Reddogs\Doctrine\Test\EntityManagerAwareTestCase;
use Reddogs\OAuth2\Server\ModuleConfig;
use Zend\Expressive\ConfigManager\PhpFileProvider;
use Reddogs\OAuth2\Server\Entity\AuthCode;
use Reddogs\OAuth2\Server\Repository\AuthCodeRepository;
use Reddogs\OAuth2\Server\Entity\Client;

class AuthCodeRepositoryTest extends EntityManagerAwareTestCase
{
    private $repository;

    protected function setUp()
    {
        $configProviders = [
            ModuleConfig::class,
            new PhpFileProvider('config/autoload/{{,*.}testing}.php'),
        ];
        $this->setConfigProviders($configProviders);
        parent::setUp();

        $this->repository = new AuthCodeRepository($this->getEntityManager());

        $this->truncateEntities([
            AuthCode::class,
            Client::class,
        ]);
    }

    public function testGetEntityManager()
    {
        $this->assertSame($this->getEntityManager(), $this->repository->getEntityManager());
    }

    public function testGetNewAuthCode()
    {
        $authCode = $this->repository->getNewAuthCode();
        $this->assertInstanceOf(AuthCode::class, $authCode);
    }

    public function testPersistNewAuthCode()
    {
        $em = $this->getEntityManager();

        $client = new Client('testIdentifier', 'testSecret');
        $em->persist($client);

        $authCode = new AuthCode('testIdentifier', $client, 17, 'http://testRedirectUri', new \DateTime());

        $this->repository->persistNewAuthCode($authCode);
        $this->assertNotNull($authCode->getId());
    }
}