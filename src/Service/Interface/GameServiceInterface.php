<? declare(strict_types=1);

namespace App\Service\Interface;

use App\DTO\Response\ResponseDTO;
use Symfony\Component\Uid\Uuid;

interface GameServiceInterface
{
    public function get(?int $max, string $traceId): ResponseDTO;
}