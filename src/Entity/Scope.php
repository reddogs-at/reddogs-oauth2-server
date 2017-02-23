<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

class Scope implements ScopeEntityInterface
{
    private $identifier;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function jsonSerialize()
    {

    }
}