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
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username = null, string $password = null)
    {
        $this->username = $username;
        $this->password = $password;
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
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param int $identifier
     */
    public function setIdentifier(int $identifier)
    {
        $this->id = $identifier;
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