<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Entity;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;

class RefreshToken implements RefreshTokenEntityInterface
{
    private $identifier;

    /**
     * Access token
     *
     * @var AccessToken
     */
    private $accessToken;

    /**
     * Expiry date time
     *
     * @var \DateTime
     */
    private $expiryDateTime;

    public function __construct(string $identifier = null, AccessToken $accessToken, \DateTime $expiryDateTime)
    {
        $this->identifier = $identifier;
        $this->accessToken = $accessToken;
        $this->expiryDateTime = $expiryDateTime;
    }

    /**
     * Get identifier
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\RefreshTokenEntityInterface::getIdentifier()
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get the token's expiry date time.
     *
     * @return \DateTime
     */
    public function getExpiryDateTime()
    {
        return $this->expiryDateTime;
    }

    /**
     * Set the date time when the token expires.
     *
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->expiryDateTime = $dateTime;
    }
}