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
use Reddogs\OAuth2\Server\Repository\AccessTokenRepository;
use Reddogs\OAuth2\Server\Entity\Client;
use Reddogs\OAuth2\Server\Entity\Scope;
use Reddogs\OAuth2\Server\Entity\AccessToken;
use Doctrine\Common\Collections\ArrayCollection;

class AccessTokenRepositoryTest extends EntityManagerAwareTestCase
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

        $this->repository = new AccessTokenRepository($this->getEntityManager());

        $this->truncateEntities([
            AccessToken::class,
            Client::class,
            Scope::class,
        ]);
        $connection = $this->getEntityManager()->getConnection();
        $connection->executeQuery($connection->getDatabasePlatform()->getTruncateTableSQL('reddogs_oauth2_server_access_token_scope'));
    }

    public function testGetEntityManager()
    {
        $this->assertSame($this->getEntityManager(), $this->repository->getEntityManager());
    }

    public function testGetNewToken()
    {
        $client = new Client();
        $scope = new Scope();
        $scopes = [$scope];
        $token = $this->repository->getNewToken($client, $scopes, 17);
        $this->assertInstanceOf(AccessToken::class, $token);
        $this->assertSame($client, $token->getClient());
        $this->assertSame(17, $token->getUserIdentifier());

        $this->assertInstanceOf(ArrayCollection::class, $token->getScopes());
        $this->assertCount(1, $token->getScopes());
        $this->assertSame($scope, $token->getScopes()->get(0));
    }

    public function testPersistNewAccessToken()
    {
        $em = $this->getEntityManager();
        $client = new Client('testIdentifier', 'testSecret');
        $em->persist($client);

        $scope = new Scope('testIdentifier');
        $em->persist($scope);

        $em->flush();

        $token = $this->repository->getNewToken($client, [$scope], 17);
        $token->setIdentifier('generatedUniqueIdentifier');
        $token->setExpiryDateTime(new \DateTime());

        $this->repository->persistNewAccessToken($token);
        $this->assertNotNull($token->getId());
    }

    public function testRevokeToken()
    {
        $em = $this->getEntityManager();
        $client = new Client('testIdentifier', 'testSecret');
        $em->persist($client);

        $scope = new Scope('testIdentifier');
        $em->persist($scope);

        $em->flush();

        $token = $this->repository->getNewToken($client, [$scope], 17);
        $token->setIdentifier('generatedUniqueIdentifier');
        $token->setExpiryDateTime(new \DateTime());

        $this->repository->persistNewAccessToken($token);
        $tokenIdentifier = $token->getIdentifier();

        $this->repository->revokeAccessToken($tokenIdentifier);

        $this->assertNull($em->getRepository(AccessToken::class)->findOneBy(['identifier' => $tokenIdentifier]));
    }

    public function testIsAccessTokenRevokedExistingTokenReturnsFalse()
    {
        $em = $this->getEntityManager();
        $client = new Client('testIdentifier', 'testSecret');
        $em->persist($client);

        $scope = new Scope('testIdentifier');
        $em->persist($scope);

        $em->flush();

        $token = $this->repository->getNewToken($client, [$scope], 17);
        $token->setIdentifier('generatedUniqueIdentifier');
        $token->setExpiryDateTime(new \DateTime());
        $this->repository->persistNewAccessToken($token);

        $this->assertFalse($this->repository->isAccessTokenRevoked('generatedUniqueIdentifier'));
    }

    public function testIsAccessTokenRevokedDeletedTokenReturnsTrue()
    {
        $this->assertTrue($this->repository->isAccessTokenRevoked('testTokenId'));
    }
}