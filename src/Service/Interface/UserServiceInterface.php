<? declare(strict_types=1);

namespace App\Service\Interface;

use App\Dto\Response\ResponseDto;
use App\Dto\User\UserDto;
use App\Dto\User\UserPartialDto;

interface UserServiceInterface
{
    /** @return ResponseDto<UserPartialDto[]> */
    public function get(?int $limit, string $traceId): ResponseDto;

    /** @return ResponseDto<UserDto> */
    public function getOne(?int $id, ?string $username, ?string $email, string $traceId): ResponseDto;

    public function create(UserDto $user, string $plainPassword, string $traceId): ResponseDto;
    public function update(UserDto $user, string $traceId): ResponseDto;
    public function delete(int $id, string $traceId): ResponseDto;
}