<? declare(strict_types=1);

namespace App\Service\Interface;

use App\DTO\Game\GamePartialDTO;
use App\DTO\Response\ResponseDTO;

interface GameServiceInterface
{
    /**
     * @return ResponseDTO<GamePartialDTO[]>
     */
    public function get(?int $limit, string $traceId): ResponseDTO;

    /** 
     * Get the games separated by different categories for the UI,
     * like popular, recommended, trending, etc
     * 
     * @return ResponseDTO
     */
    public function getWithCategories(string $traceId): ResponseDTO;

    /**
     * @return ResponseDTO<GamePartialDTO>
     */
    public function getById(int $id, string $traceId): ResponseDTO;
}