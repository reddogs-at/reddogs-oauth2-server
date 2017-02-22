<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\Oauth2\Server\Entity;

use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="reddogs_oauth2_server_client")
 */
class Client implements ClientEntityInterface
{
    private $identifier;

    private $name;

    public function __construct(string $identifier = null, string $name = null)
    {
        $this->identifier = $identifier;
        $this->name = $name;
    }

    public function getIdentifier() : string
    {
        return $this->identifier;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getRedirectUri()
    {

    }
}