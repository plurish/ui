<?php

namespace App\Repository;

use App\Entity\UserEntity;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interface\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<UserEntity>
 *
 * @implements PasswordUpgraderInterface<UserEntity>
 *
 * @method UserEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntity[]    findAll()
 * @method UserEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ?UserEntity     getOne(string $username, ?string $email = '')
 * @method bool            create(UserEntity $user)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    public function getOne(string $username, ?string $email = ''): ?UserEntity
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $email)
            ->getQuery();

        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function create(UserEntity $user): bool
    {
        $this->_em->persist($user);

        $this->_em->flush();

        return true;
    }

    public function update(UserEntity $user): bool
    {
        $this->_em->flush();

        return true;
    }

    public function delete(int $id): bool
    {
        $user = $this->_em->getReference(UserEntity::class, $id);

        $this->_em->remove($user);

        $this->_em->flush();

        return true;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof UserEntity) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
