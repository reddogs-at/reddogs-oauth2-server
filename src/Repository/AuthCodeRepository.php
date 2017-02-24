<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Repository;

use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use Reddogs\Doctrine\ORM\EntityManagerAwareTrait;
use Doctrine\ORM\EntityManager;
use Reddogs\OAuth2\Server\Entity\AuthCode;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    use EntityManagerAwareTrait;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     * Get new auth code
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface::getNewAuthCode()
     */
    public function getNewAuthCode()
    {
        return new AuthCode();
    }

    /**
     * Persist new auth code
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface::persistNewAuthCode()
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $em = $this->getEntityManager();
        $em->persist($authCodeEntity);
        $em->flush($authCodeEntity);
    }

    /**
     * Revoke auth code
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface::revokeAuthCode()
     */
    public function revokeAuthCode($codeId)
    {

    }

    /**
     * Is auth code revoked
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface::isAuthCodeRevoked()
     */
    public function isAuthCodeRevoked($codeId)
    {

    }
}