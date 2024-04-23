<? declare(strict_types=1);

namespace App\Dto\User;

class UserDto
{
    public function __construct(
        public readonly int $id = 0,
        public readonly string $username,
        public readonly string $email,
        public readonly bool $active,
        public readonly array $roles = ['ROLE_PLAYER'],
    ) {
    }
}