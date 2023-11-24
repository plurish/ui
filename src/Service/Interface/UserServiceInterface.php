<? declare(strict_types=1);

namespace App\Service\Interface;

use App\DTO\Response\ResponseDTO;
use App\DTO\User\UserDTO;
use App\DTO\User\UserPartialDTO;

interface UserServiceInterface
{
    /** @return ResponseDTO<UserPartialDTO[]> */
    public function get(?int $limit, string $traceId): ResponseDTO;

    /** @return ResponseDTO<UserDTO> */
    public function getOne(?int $id, ?string $username, ?string $email, string $traceId): ResponseDTO;

    public function create(UserDTO $user, string $plainPassword, string $traceId): ResponseDTO;
    public function update(UserDTO $user, string $traceId): ResponseDTO;
    public function delete(int $id, string $traceId): ResponseDTO;
}