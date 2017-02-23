<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace ReddogsTest\OAuth2\Server;

use Reddogs\Doctrine\Test\EntityManagerAwareTestCase;
use Reddogs\OAuth2\Server\Entity\Client;
use Reddogs\OAuth2\Server\ModuleConfig;
use Zend\Expressive\ConfigManager\PhpFileProvider;
use Reddogs\OAuth2\Server\Repository\ClientRepository;
use Zend\Crypt\Password\Bcrypt;

class ClientRepositoryTest extends EntityManagerAwareTestCase
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
            Client::class
        ]);

        $this->bcrypt = $this->getMockBuilder(Bcrypt::class)
            ->setMethods(['verify'])
            ->getMock();

        $this->repository = new ClientRepository($this->getEntityManager(), $this->bcrypt);
    }

    public function testGetEntityManager()
    {
        $this->assertSame($this->getEntityManager(), $this->repository->getEntityManager());
    }

    public function testGetBcrypt()
    {
        $this->assertSame($this->bcrypt, $this->repository->getBcrypt());
    }

    public function testGetClientEntity()
    {
        $em = $this->getEntityManager();
        $client = new Client('testIdentifier', 'testSecret', 'testName', 'http://testRedirectUri', array('code', 'password'));
        $em->persist($client);
        $em->flush();

        $this->assertEquals($client, $this->repository->getClientEntity('testIdentifier', 'code', null, false));
    }

    public function testGetClientEntityInvalidIdentifierReturnsNull()
    {
        $em = $this->getEntityManager();
        $client = new Client('testIdentifier', 'testSecret', 'testName', 'http://testRedirectUri', array('code', 'password'));
        $em->persist($client);
        $em->flush();

        $this->assertNull($this->repository->getClientEntity('invalidIdentifier', 'code', null, false));
    }

    public function testGetClientEntityWrongGrantTypeReturnsNull()
    {
        $em = $this->getEntityManager();
        $client = new Client('testIdentifier', 'testSecret', 'testName', 'http://testRedirectUri', array('code', 'password'));
        $em->persist($client);
        $em->flush();

        $this->assertNull($this->repository->getClientEntity('testIdentifier', 'authorization_code', null, false));
    }

    public function testGetClientEntityMustValidateSecret()
    {
        $em = $this->getEntityManager();
        $client = new Client('testIdentifier', 'cryptedTestSecret', 'testName', 'http://testRedirectUri', array('code', 'password'));
        $em->persist($client);
        $em->flush();

        $this->bcrypt->expects($this->once())
            ->method('verify')
            ->with($this->equalTo('testSecret'),
                   $this->equalTo('cryptedTestSecret'))
            ->will($this->returnValue(true));

        $this->assertEquals($client, $this->repository->getClientEntity('testIdentifier', 'code', 'testSecret', true));
    }

    public function testGetClientEntityMustValidateSecretInvalidSecretReturnsNull()
    {
        $em = $this->getEntityManager();
        $client = new Client('testIdentifier', 'cryptedTestSecret', 'testName', 'http://testRedirectUri', array('code', 'password'));
        $em->persist($client);
        $em->flush();

        $this->bcrypt->expects($this->once())
            ->method('verify')
            ->with($this->equalTo('InvalidSecret'),
                   $this->equalTo('cryptedTestSecret'))
            ->will($this->returnValue(false));

        $this->assertNull($this->repository->getClientEntity('testIdentifier', 'code', 'InvalidSecret', true));
    }
}

