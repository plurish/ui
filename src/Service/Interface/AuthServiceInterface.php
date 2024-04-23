<? declare(strict_types=1);

namespace App\Service\Interface;

use App\Dto\Request\SignUpRequestDto;
use App\Dto\Response\ResponseDto;
use App\Dto\User\UserPartialDto;
use Symfony\Component\HttpFoundation\Request;

interface AuthServiceInterface
{
    /** @return ResponseDto<bool> */
    public function signup(SignUpRequestDto $request, string $traceId): ResponseDto;


    /** @return ResponseDto<UserPartialDto> */
    public function getAuthenticatedUser(Request $request): ResponseDto;
}