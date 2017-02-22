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
use Reddogs\OAuth2\Server\Entity\User;
use Reddogs\OAuth2\Server\Repository\UserRepository;
use Zend\Crypt\Password\Bcrypt;
use Reddogs\OAuth2\Server\Entity\Client;

class UserRepositoryTest extends EntityManagerAwareTestCase
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
            User::class
        ]);
        $this->repository = new UserRepository($this->getEntityManager());
    }

    public function testGetEntityManager()
    {
        $this->assertSame($this->getEntityManager(), $this->repository->getEntityManager());
    }

    public function testGetUserEntityByUserCredentials()
    {
        $em = $this->getEntityManager();
        $bcrypt = new Bcrypt();
        $user = new User('testUsername', $bcrypt->create('testPassword'));
        $em->persist($user);
        $em->flush();
        $this->assertEquals(
            $user,
            $this->repository->getUserEntityByUserCredentials(
                'testUsername', 'testPassword', 'code', new Client()
            )
        );
    }

    public function testGetUserEntityByUserCredentialsInvalidPasswordReturnsNull()
    {
        $em = $this->getEntityManager();
        $bcrypt = new Bcrypt();
        $user = new User('testUsername', $bcrypt->create('testPassword'));
        $em->persist($user);
        $em->flush();
        $this->assertNull(
            $this->repository->getUserEntityByUserCredentials(
                'testUsername', 'invalidPassword', 'code', new Client()
            )
        );
    }

}