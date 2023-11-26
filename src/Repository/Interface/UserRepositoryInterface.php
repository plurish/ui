<? declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

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
interface UserRepositoryInterface
{
    public function getOne(string $username, ?string $email = ''): ?UserEntity;
    public function create(UserEntity $user): bool;
    public function update(UserEntity $user): bool;
    public function delete(int $id): bool;
}