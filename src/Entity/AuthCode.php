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
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reddogs_oauth2_server_auth_code")
 */
class AuthCode implements AuthCodeEntityInterface
{
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
     * Redirect uri
     *
     * @ORM\Column(type="string", name="redirect_uri")
     *
     * @var null|string
     */
    private $redirectUri;

   /**
    * Scopes
    *
    * @ORM\ManyToMany(targetEntity="Scope")
    * @ORM\JoinTable(name="reddogs_oauth2_server_auth_code_scope",
    *      joinColumns={@ORM\JoinColumn(name="auth_code_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
    * )
    * @var ArrayCollection
    */
    private $scopes;

    /**
     * Expiry date time
     *
     * @ORM\Column(type="datetime", name="expiry_date_time")
     *
     * @var \DateTime
     */
    private $expiryDateTime;

    /**
     * User identifier
     *
     * @ORM\Column(type="string", name="user_identifier")
     * @var string
     */
    private $userIdentifier;

    /**
     * Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     *
     * @var ClientEntityInterface
     */
    private $client;

    /**
     * Constructor
     *
     * @param unknown $identifier
     * @param Client $client
     * @param int $userId
     * @param string $redirectUri
     * @param \DateTime $expiryDateTime
     */
    public function __construct(string $identifier = null, Client $client = null, int $userId = null,
        string $redirectUri = null, \DateTime $expiryDateTime = null)
    {
        $this->identifier = $identifier;
        $this->client = $client;
        $this->userIdentifier = $userId;
        $this->redirectUri = $redirectUri;
        $this->expiryDateTime = $expiryDateTime;
        $this->scopes = new ArrayCollection();
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
     * @todo return array instead of array collection
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
        $this->userIdentifier = $identifier;
    }

    /**
     * Get the token user's identifier.
     *
     * @return string|int
     */
    public function getUserIdentifier()
    {
        return $this->userIdentifier;
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