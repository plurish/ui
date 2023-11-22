<? declare(strict_types=1);

namespace App\Service\Interface;

use App\DTO\Request\SignUpRequestDTO;
use App\DTO\Response\ResponseDTO;
use App\DTO\UserDTO;
use Symfony\Component\HttpFoundation\Request;

interface AuthServiceInterface
{
    /** @return ResponseDTO<bool> */
    public function signup(SignUpRequestDTO $request, string $traceId): ResponseDTO;


    /** @return ResponseDTO<UserDTO> */
    public function getAuthenticatedUser(Request $request): ResponseDTO;
}