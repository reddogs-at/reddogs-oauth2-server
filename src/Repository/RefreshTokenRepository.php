<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Repository;

use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use Reddogs\Doctrine\ORM\EntityManagerAwareTrait;
use Doctrine\ORM\EntityManager;
use Reddogs\OAuth2\Server\Entity\RefreshToken;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
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
     * Get new refresh token
     *
     * {@inheritdoc}
     *
     * @see \League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface::getNewRefreshToken()
     */
    public function getNewRefreshToken()
    {
        $refreshToken = new RefreshToken();
        return $refreshToken;
    }

    /**
     * Persist new refresh token
     *
     * {@inheritdoc}
     *
     * @see \League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface::persistNewRefreshToken()
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $em = $this->getEntityManager();
        $em->persist($refreshTokenEntity);
        $em->flush($refreshTokenEntity);
    }

    /**
     * Revoke refresh token
     *
     * {@inheritdoc}
     *
     * @see \League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface::revokeRefreshToken()
     */
    public function revokeRefreshToken($tokenId)
    {
        $em = $this->getEntityManager();
        $refreshToken = $em->getRepository(RefreshToken::class)->findOneBy([
            'identifier' => $tokenId
        ]);
        $em->remove($refreshToken);
        $em->flush($refreshToken);
    }

    /**
     * Is refresh token revoked
     *
     * {@inheritdoc}
     *
     * @see \League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface::isRefreshTokenRevoked()
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return (null === $this->getEntityManager()
            ->getRepository(RefreshToken::class)
            ->findOneBy([
            'identifier' => $tokenId
        ]));
    }
}