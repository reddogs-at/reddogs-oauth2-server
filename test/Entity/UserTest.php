<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Entity;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp()
    {
        $this->user = new User('testIdentifier', 'testUsername', 'testPassword');
    }

    public function testGetIdentifier()
    {
        $this->assertSame('testIdentifier', $this->user->getIdentifier());
    }

    public function testSetIdentifier()
    {
        $this->user->setIdentifier('newIdentifier');
        $this->assertSame('newIdentifier', $this->user->getIdentifier());
    }

    public function testGetUsername()
    {
        $this->assertSame('testUsername', $this->user->getUsername());
    }

    public function testGetPassword()
    {
        $this->assertSame('testPassword', $this->user->getPassword());
    }
}