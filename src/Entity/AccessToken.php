<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Entity;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;

class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;

    /**
     * Identifier
     *
     * @var string
     */
    private $identifier;

    /**
     * Scopes
     *
     * @var ArrayCollection
     */
    private $scopes;

    /**
     * Expiry date time
     *
     * @var \DateTime
     */
    private $expiryDateTime;

    /**
     * User identifier
     *
     * @var int
     */
    private  $userId;

    /**
     * User
     *
     * @var User
     */
    private $user;

    /**
     * Client
     *
     * @var ClientEntityInterface
     */
    private $client;

    public function __construct($identifier = null, Client $client = null, User $user = null,
        \DateTime $expiryDateTime)
    {
        $this->identifier = $identifier;
        $this->client = $client;
        $this->user = $user;
        $this->userId = $user->getIdentifier();
        $this->scopes = new ArrayCollection();
        $this->expiryDateTime = $expiryDateTime;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
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
     * Set user identifier
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\TokenInterface::setUserIdentifier()
     */
    public function setUserIdentifier($identifier)
    {
        if ($this->getUser()->getIdentifier() !== $identifier) {
            $this->user = null;
        }
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

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}