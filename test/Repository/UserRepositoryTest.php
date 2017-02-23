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
    private $repository, $bcrypt;

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

        $this->bcrypt = $this->getMockBuilder(Bcrypt::class)
            ->setMethods(['verify'])
            ->getMock();

        $this->repository = new UserRepository($this->getEntityManager(), $this->bcrypt);
    }

    public function testGetEntityManager()
    {
        $this->assertSame($this->getEntityManager(), $this->repository->getEntityManager());
    }

    public function testGetBcrypt()
    {
        $this->assertSame($this->bcrypt, $this->repository->getBcrypt());
    }

    public function testGetUserEntityByUserCredentials()
    {
        $em = $this->getEntityManager();
        $user = new User('testIdentifier', 'testUsername', 'cryptedTestPassword');
        $em->persist($user);
        $em->flush();

        $this->bcrypt->expects($this->once())
            ->method('verify')
            ->with($this->equalTo('testPassword'),
                   $this->equalTo('cryptedTestPassword'))
            ->will($this->returnValue(true));


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
        $user = new User('testIdentifier', 'testUsername', 'cryptedTestPassword');
        $em->persist($user);
        $em->flush();

        $this->bcrypt->expects($this->once())
            ->method('verify')
            ->with($this->equalTo('invalidPassword'),
                   $this->equalTo('cryptedTestPassword'))
            ->will($this->returnValue(false));
        $this->assertNull(
            $this->repository->getUserEntityByUserCredentials(
                'testUsername', 'invalidPassword', 'code', new Client()
            )
        );
    }

}