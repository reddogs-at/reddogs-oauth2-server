<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Entity;

use League\OAuth2\Server\Entities\UserEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reddogs_oauth2_server_user")
 */
class User implements UserEntityInterface
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
     * Username
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $username;

    /**
     * Password
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $password;

    /**
     * Constructor
     *
     * @param string $identifier
     * @param string $username
     * @param string $password
     */
    public function __construct(string $identifier, string $username = null, string $password = null)
    {
        $this->identifier = $identifier;
        $this->username = $username;
        $this->password = $password;
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
     * {@inheritdoc}
     *
     * @see \League\OAuth2\Server\Entities\UserEntityInterface::getIdentifier()
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
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}