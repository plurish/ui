<? declare(strict_types=1);

namespace App\Service\Interface;

use App\Dto\Game\GamePartialDto;
use App\Dto\Response\ResponseDto;

interface GameServiceInterface
{
    /**
     * @return ResponseDto<GamePartialDto[]>
     */
    public function get(?int $limit, string $traceId): ResponseDto;

    /** 
     * Get the games separated by different categories for the UI,
     * like popular, recommended, trending, etc
     * 
     * @return ResponseDto
     */
    public function getWithCategories(string $traceId): ResponseDto;

    /**
     * @return ResponseDto<GamePartialDto>
     */
    public function getById(int $id, string $traceId): ResponseDto;
}