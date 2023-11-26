<? declare(strict_types=1);

namespace App\Enum;

enum RoleEnum: string
{
    case ROLE_PLAYER = 'ROLE_PLAYER';
    case ROLE_ADMIN = 'ROLE_ADMIN';
}