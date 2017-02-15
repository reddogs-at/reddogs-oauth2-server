<?php

namespace ReddogsTest\OAuth2\Server\Entity;

use PHPUnit\Framework\TestCase;
use Reddogs\OAuth2\Server\Entity\Client;

class ClientTest extends TestCase
{
    private $client;

    protected function setUp()
    {
        $this->client = new Client('testIdentifier', 'testName');
    }

    public function testGetIdentifier()
    {
        $this->assertSame('testIdentifier', $this->client->getIdentifier());
    }

    public function testGetName()
    {
        $this->assertSame('testName', $this->client->getName());
    }
}