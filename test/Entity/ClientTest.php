<?php

namespace ReddogsTest\OAuth2\Server\Entity;

use PHPUnit\Framework\TestCase;
use Reddogs\OAuth2\Server\Entity\Client;

class ClientTest extends TestCase
{
    private $client;

    protected function setUp()
    {
        $this->client = new Client('testIdentifier', 'testSecret', 'testName', 'https://testRedirectUri', ['password', 'code']);
    }

    public function testGetId()
    {
        $this->assertNull($this->client->getId());
    }

    public function testGetIdentifier()
    {
        $this->assertSame('testIdentifier', $this->client->getIdentifier());
    }

    public function testGetSecret()
    {
        $this->assertSame('testSecret', $this->client->getSecret());
    }

    public function testGetName()
    {
        $this->assertSame('testName', $this->client->getName());
    }

    public function testGetRedirectUri()
    {
        $this->assertSame('https://testRedirectUri', $this->client->getRedirectUri());
    }

    public function testGetGrantTypes()
    {
        $this->assertSame(['password', 'code'], $this->client->getGrantTypes());
    }

}