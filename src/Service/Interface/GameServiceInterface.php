<? declare(strict_types=1);

namespace App\Service\Interface;

use App\DTO\Response\ResponseDTO;

interface GameServiceInterface
{
    public function get(?int $limit, string $traceId): ResponseDTO;
    public function getById(int $id, string $traceId): ResponseDTO;
}