<? declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\UserEntity;

interface UserRepositoryInterface
{
    public function getOne(string $username, ?string $email = ''): ?UserEntity;
    public function create(UserEntity $user): bool;
}