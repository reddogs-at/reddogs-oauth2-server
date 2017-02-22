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
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="reddogs_oauth2_server_client")
 */
class Client implements ClientEntityInterface
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
     * Secret
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $secret;

    /**
     * Name
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * Redirect uri
     *
     * @ORM\Column(type="string", name="redirect_uri")
     *
     * @var string
     */
    private $redirectUri;

    /**
     * Grant types
     *
     * @ORM\Column(type="simple_array", name="grant_types")
     *
     * @var array
     */
    private $grantTypes;

    /**
     * Constructor
     *
     * @param string $identifier
     * @param string $name
     * @param string $redirectUri
     * @param array $grantTypes
     */
    public function __construct(string $identifier = null, string $secret = null, string $name = null,
        string $redirectUri = null, array $grantTypes = [])
    {
        $this->identifier = $identifier;
        $this->secret = $secret;
        $this->name = $name;
        $this->redirectUri = $redirectUri;
        $this->grantTypes = $grantTypes;
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
     * @see \League\OAuth2\Server\Entities\ClientEntityInterface::getIdentifier()
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Get secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Get name
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\ClientEntityInterface::getName()
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get redirect uri
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Entities\ClientEntityInterface::getRedirectUri()
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Get grant types
     *
     * @return array
     */
    public function getGrantTypes()
    {
        return $this->grantTypes;
    }

}