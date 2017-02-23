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
use Reddogs\OAuth2\Server\Entity\AuthCode;
use Reddogs\OAuth2\Server\Entity\Client;
use Doctrine\Common\Collections\ArrayCollection;
use Reddogs\OAuth2\Server\Entity\Scope;

class AuthCodeTest extends TestCase
{
    private $authCode, $client, $expiryDateTime;

    protected function setUp()
    {
        $this->client = new Client();
        $this->expiryDateTime = new \DateTime();
        $this->authCode = new AuthCode('testIdentifier', $this->client, 17, 'testRedirectUri', $this->expiryDateTime);
    }

    public function testGetIdentifier()
    {
        $this->assertSame('testIdentifier', $this->authCode->getIdentifier());
    }

    public function testSetIdentifier()
    {
        $this->authCode->setIdentifier('newIdentifer');
        $this->assertSame('newIdentifer', $this->authCode->getIdentifier());
    }

    public function testGetClient()
    {
        $this->assertSame($this->client, $this->authCode->getClient());
    }

    public function testSetClient()
    {
        $client = new Client();
        $this->authCode->setClient($client);
        $this->assertSame($client, $this->authCode->getClient());
    }

    public function testGetUserIdentifier()
    {
        $this->assertSame(17, $this->authCode->getUserIdentifier());
    }

    public function testSetUserIdentifier()
    {
        $this->authCode->setUserIdentifier(23);
        $this->assertSame(23, $this->authCode->getUserIdentifier());
    }

    public function testGetRedirectUri()
    {
        $this->assertSame('testRedirectUri', $this->authCode->getRedirectUri());
    }

    public function testSetRedirectUri()
    {
        $this->authCode->setRedirectUri('newRedirectUri');
        $this->assertSame('newRedirectUri', $this->authCode->getRedirectUri());
    }

    public function testGetExpiryTime()
    {
        $this->assertSame($this->expiryDateTime, $this->authCode->getExpiryDateTime());
    }

    public function testSetExpiryDateTime()
    {
        $expiryDateTime = new \DateTime();
        $this->authCode->setExpiryDateTime($expiryDateTime);
        $this->assertSame($expiryDateTime, $this->authCode->getExpiryDateTime());
    }

    public function testGetScopes()
    {
        $this->assertInstanceOf(ArrayCollection::class, $this->authCode->getScopes());
    }

    public function testAddScope()
    {
        $scope = new Scope();
        $this->authCode->addScope($scope);

        $scopes = $this->authCode->getScopes();
        $this->assertInstanceOf(ArrayCollection::class, $scopes);
        $this->assertCount(1, $scopes);
        $this->assertSame($scope, $scopes[0]);
    }
}