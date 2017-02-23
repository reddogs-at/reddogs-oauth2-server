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
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reddogs_oauth2_server_access_token")
 */
class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;

    /**
     * Id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    private $id;

    /**
     * Identifier
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $identifier;

    /**
     * Scopes
     *
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(name="reddogs_oauth2_server_access_token_scope",
     *      joinColumns={@ORM\JoinColumn(name="access_token_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
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

    public function __construct($identifier = null, Client $client = null, $userId = null,
        \DateTime $expiryDateTime = null)
    {
        $this->identifier = $identifier;
        $this->client = $client;
        $this->userId = $userId;
        $this->scopes = new ArrayCollection();
        $this->expiryDateTime = $expiryDateTime;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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