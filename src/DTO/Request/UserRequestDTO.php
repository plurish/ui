<? declare(strict_types=1);

namespace App\DTO\Request;

use App\DTO\User\UserDTO;

class UserRequestDTO extends UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $email,
        public readonly string $password,
        public readonly bool $active,
        public readonly array $roles,
    ) {
    }
}