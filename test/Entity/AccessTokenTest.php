<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace ReddogsTest\OAuth2\Server\Entity;

use PHPUnit\Framework\TestCase;
use Reddogs\OAuth2\Server\Entity\AccessToken;
use Reddogs\OAuth2\Server\Entity\Client;
use Reddogs\OAuth2\Server\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Reddogs\OAuth2\Server\Entity\Scope;

class AccessTokenTest extends TestCase
{
    private $accessToken, $client, $user, $expiryDateTime;

    protected function setUp()
    {
        $this->client = new Client('testIdentifier');
        $this->user = new User('testUsername');
        $this->user->setIdentifier(17);
        $this->expiryDateTime = new \DateTime();
        $this->accessToken = new AccessToken('testIdentifier', $this->client, $this->user, $this->expiryDateTime);
    }

    public function testGetIdentifier()
    {
        $this->assertSame('testIdentifier', $this->accessToken->getIdentifier());
    }

    public function testGetClient()
    {
        $this->assertSame($this->client, $this->accessToken->getClient());
    }

    public function testGetUser()
    {
        $this->assertSame($this->user, $this->accessToken->getUser());
    }

    public function testGetUserIdentifier()
    {
        $this->assertSame(17, $this->accessToken->getUserIdentifier());
    }

    public function testSetUserIdentifier()
    {
        $this->accessToken->setUserIdentifier(23);
        $this->assertSame(23, $this->accessToken->getUserIdentifier());
        $this->assertNull($this->accessToken->getUser());
    }

    public function testGetScopes()
    {
        $this->assertInstanceOf(ArrayCollection::class, $this->accessToken->getScopes());
    }

    public function testAddScope()
    {
        $scope = new Scope();
        $this->accessToken->addScope($scope);

        $scopes = $this->accessToken->getScopes();
        $this->assertInstanceOf(ArrayCollection::class, $scopes);
        $this->assertCount(1, $scopes);
        $this->assertSame($scope, $scopes[0]);
    }

    public function testGetExpiryTime()
    {
        $this->assertSame($this->expiryDateTime, $this->accessToken->getExpiryDateTime());
    }

    public function testSetExpiryDateTime()
    {
        $expiryDateTime = new \DateTime();
        $this->accessToken->setExpiryDateTime($expiryDateTime);
        $this->assertSame($expiryDateTime, $this->accessToken->getExpiryDateTime());
    }
}