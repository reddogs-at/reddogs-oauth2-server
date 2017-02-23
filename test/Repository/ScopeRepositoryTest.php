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
use Reddogs\OAuth2\Server\Entity\Scope;
use Reddogs\OAuth2\Server\Repository\ScopeRepository;
use Reddogs\OAuth2\Server\Entity\Client;

class ScopeRepositoryTest extends EntityManagerAwareTestCase
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
           Scope::class
        ]);

        $this->repository = new ScopeRepository($this->getEntityManager());
    }

    public function testGetEntityManager()
    {
        $this->assertSame($this->getEntityManager(), $this->repository->getEntityManager());
    }

    public function testGetScopeEntityByIdentifier()
    {
        $em = $this->getEntityManager();
        $scope = new Scope('testIdentifier');
        $em->persist($scope);
        $em->flush($scope);

        $this->assertSame($scope, $this->repository->getScopeEntityByIdentifier('testIdentifier'));
    }

    public function testFinalizeScopes()
    {
        $em = $this->getEntityManager();
        $scope1 = new Scope('testIdentifier');
        $em->persist($scope1);

        $scope2 = new Scope('email');
        $em->persist($scope2);

        $client = new Client();

        $em->flush();

        $scopes = $this->repository->finalizeScopes([$scope1, $scope2], 'password', $client);
        $this->assertCount(1, $scopes);
        $this->assertSame($scope2, $scopes[0]);
    }
}