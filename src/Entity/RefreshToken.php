<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Entity;

use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="reddogs_oauth2_server_refresh_token")
 */
class RefreshToken implements RefreshTokenEntityInterface
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
     * Access token
     *
     * @ORM\OneToOne(targetEntity="AccessToken")
     * @ORM\JoinColumn(name="access_token_id", referencedColumnName="id")
     *
     * @var AccessToken
     */
    private $accessToken;

    /**
     * Expiry date time
     *
     * @ORM\Column(type="datetime", name="expiry_date_time")
     *
     * @var \DateTime
     */
    private $expiryDateTime;

    /**
     * Constructor
     *
     * @param string $identifier
     * @param AccessToken $accessToken
     * @param \DateTime $expiryDateTime
     */
    public function __construct(string $identifier = null, AccessToken $accessToken = null,
        \DateTime $expiryDateTime = null)
    {
        $this->identifier = $identifier;
        $this->accessToken = $accessToken;
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
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\RefreshTokenEntityInterface::getIdentifier()
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set identifier
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\RefreshTokenEntityInterface::setIdentifier()
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Set access token
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\RefreshTokenEntityInterface::setAccessToken()
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Get access token
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\RefreshTokenEntityInterface::getAccessToken()
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get expiry datetime
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\RefreshTokenEntityInterface::getExpiryDateTime()
     */
    public function getExpiryDateTime()
    {
        return $this->expiryDateTime;
    }

    /**
     * Set expiry datetime
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\RefreshTokenEntityInterface::setExpiryDateTime()
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->expiryDateTime = $dateTime;
    }
}