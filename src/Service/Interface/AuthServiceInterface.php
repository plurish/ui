<? declare(strict_types=1);

namespace App\Service\Interface;

use App\DTO\Request\SignUpRequestDTO;
use App\DTO\Response\ResponseDTO;

interface AuthServiceInterface
{
    public function signup(SignUpRequestDTO $request, string $traceId): ResponseDTO;
}