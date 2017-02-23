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
use Reddogs\OAuth2\Server\Entity\Scope;

class ScopeTest extends TestCase
{
    protected function setUp()
    {
        $this->scope = new Scope();
    }

    public function testGetidentifier()
    {
        $this->assertNull($this->scope->getIdentifier());
    }

    public function testJsonSerialize()
    {
        $this->markTestIncomplete('dont know how to implement at the moment');
    }
}