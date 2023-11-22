<? declare(strict_types=1);

namespace App\DTO;

class UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $email,
        public readonly array $roles,
    ) {
    }
}