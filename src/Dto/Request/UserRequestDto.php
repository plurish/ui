<? declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\User\UserDto;

class UserRequestDto extends UserDto
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