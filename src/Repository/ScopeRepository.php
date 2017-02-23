<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Repository;

use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Reddogs\Doctrine\ORM\EntityManagerAwareTrait;
use Doctrine\ORM\EntityManager;
use Reddogs\OAuth2\Server\Entity\Scope;

class ScopeRepository implements ScopeRepositoryInterface
{
    use EntityManagerAwareTrait;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\ScopeRepositoryInterface::getScopeEntityByIdentifier()
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        return $this->getEntityManager()->getRepository(Scope::class)->findOneBy(['identifier' => $identifier]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\ScopeRepositoryInterface::finalizeScopes()
     *
     * At the moment only scope 'email' is allowed
     * @todo integrate permission system
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity,
        $userIdentifier = null)
    {
        $scopes = [
            $this->getScopeEntityByIdentifier('email')
        ];
        return $scopes;
    }
}