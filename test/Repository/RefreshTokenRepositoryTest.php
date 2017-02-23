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
use Reddogs\OAuth2\Server\Entity\RefreshToken;
use Reddogs\OAuth2\Server\Repository\RefreshTokenRepository;
use Reddogs\OAuth2\Server\Entity\AccessToken;
use Reddogs\OAuth2\Server\Entity\Client;

class RefreshTokenRepositoryTest extends EntityManagerAwareTestCase
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

        $this->truncateEntities([
            RefreshToken::class,
            AccessToken::class,
            Client::class,
        ]);

        $this->repository = new RefreshTokenRepository($this->getEntityManager());
    }

    public function testGetEntityManager()
    {
        $this->assertSame($this->getEntityManager(), $this->repository->getEntityManager());
    }

    public function testGetNewRefreshToken()
    {
        $refreshToken = $this->repository->getNewRefreshToken();
        $this->assertInstanceOf(RefreshToken::class, $refreshToken);
    }

    public function testPersistNewRefreshToken()
    {
        $em = $this->getEntityManager();

        $client = new Client('testIdentifier', 'testSecret');
        $em->persist($client);

        $accessToken = new AccessToken('testIdentifier', $client, 17, new \DateTime());
        $em->persist($accessToken);

        $em->flush();

        $refreshToken = $this->repository->getNewRefreshToken();
        $refreshToken->setExpiryDateTime(new \DateTime());
        $refreshToken->setIdentifier('testIdentifier');
        $refreshToken->setAccessToken($accessToken);

        $this->repository->persistNewRefreshToken($refreshToken);

        $this->assertNotNull($refreshToken->getId());
    }

    public function testRevokeRefreshToken()
    {
        $em = $this->getEntityManager();

        $client = new Client('testIdentifier', 'testSecret');
        $em->persist($client);

        $accessToken = new AccessToken('testIdentifier', $client, 17, new \DateTime());
        $em->persist($accessToken);

        $refreshToken = new RefreshToken('testTokenId', $accessToken, new \DateTime());
        $em->persist($refreshToken);

        $em->flush();

        $this->repository->revokeRefreshToken('testTokenId');

        $this->assertNull($em->getRepository(RefreshToken::class)->findOneBy(['identifier' => 'testTokenId']));
    }

    public function testIsRefreshTokenRevokedExistingTokenReturnsFalse()
    {
        $em = $this->getEntityManager();

        $client = new Client('testIdentifier', 'testSecret');
        $em->persist($client);

        $accessToken = new AccessToken('testIdentifier', $client, 17, new \DateTime());
        $em->persist($accessToken);

        $refreshToken = new RefreshToken('testTokenId', $accessToken, new \DateTime());
        $em->persist($refreshToken);

        $em->flush();

        $this->assertFalse($this->repository->isRefreshTokenRevoked('testTokenId'));
    }

    public function testIsRefreshTokenRevokedDeletedTokenReturnsTrue()
    {
        $this->assertTrue($this->repository->isRefreshTokenRevoked('testTokenId'));
    }
}