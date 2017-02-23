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
use Reddogs\OAuth2\Server\Entity\RefreshToken;
use Reddogs\OAuth2\Server\Entity\AccessToken;

class RefreshTokenTest extends TestCase
{
    private $refreshToken, $accessToken, $expiryDateTime;

    protected function setUp()
    {
        $this->accessToken = new AccessToken();
        $this->expiryDateTime = new \DateTime();
        $this->refreshToken = new RefreshToken('testIdentifier', $this->accessToken, $this->expiryDateTime);
    }

    public function testGetId()
    {
        $this->assertNull($this->refreshToken->getId());
    }

    public function testGetIdentifier()
    {
        $this->assertSame('testIdentifier', $this->refreshToken->getIdentifier());
    }

    public function testGetAccessToken()
    {
        $this->assertSame($this->accessToken, $this->refreshToken->getAccessToken());
    }

    public function testSetAccessToken()
    {
        $accessToken = new AccessToken();
        $this->refreshToken->setAccessToken($accessToken);
        $this->assertSame($accessToken, $this->refreshToken->getAccessToken());
    }

    public function testGetExpiryDateTime()
    {
        $this->assertSame($this->expiryDateTime, $this->refreshToken->getExpiryDateTime());
    }

    public function testSetExpiryDateTime()
    {
        $expiryDateTime = new \DateTime();
        $this->refreshToken->setExpiryDateTime($expiryDateTime);
        $this->assertSame($expiryDateTime, $this->refreshToken->getExpiryDateTime());
    }
}