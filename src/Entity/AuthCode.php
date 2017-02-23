<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Entity;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;

class AuthCode implements AuthCodeEntityInterface
{
    private $identifier;

    /**
     * @var null|string
     */
    private $redirectUri;

   /**
    * @var ArrayCollection
    */
    private $scopes;

    /**
     * @var \DateTime
     */
    private $expiryDateTime;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var ClientEntityInterface
     */
    private $client;

    public function __construct($identifier = null, Client $client = null, int $userId = null,
        string $redirectUri = null, \DateTime $expiryDateTime = null)
    {
        $this->identifier = $identifier;
        $this->client = $client;
        $this->userId = $userId;
        $this->redirectUri = $redirectUri;
        $this->expiryDateTime = $expiryDateTime;
        $this->scopes = new ArrayCollection();
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

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param string $uri
     */
    public function setRedirectUri($uri)
    {
        $this->redirectUri = $uri;
    }

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        $this->getScopes()->add($scope);
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return ArrayCollection
     */
    public function getScopes()
    {
        return $this->scopes;
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

    /**
     * Set the identifier of the user associated with the token.
     *
     * @param string|int $identifier The identifier of the user
     */
    public function setUserIdentifier($identifier)
    {
        $this->userId = $identifier;
    }

    /**
     * Get the token user's identifier.
     *
     * @return string|int
     */
    public function getUserIdentifier()
    {
        return $this->userId;
    }

    /**
     * Get the client that the token was issued to.
     *
     * @return ClientEntityInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the client that the token was issued to.
     *
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->client = $client;
    }
}