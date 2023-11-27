<? declare(strict_types=1);

namespace App\DTO\User;

class UserDTO
{
    public function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly bool $active,
        public readonly array $roles = ['ROLE_PLAYER'],
        public readonly int $id = 0,
    ) {
    }
}