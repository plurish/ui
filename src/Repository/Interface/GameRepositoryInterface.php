<? declare(strict_types=1);

namespace App\Repository\Interface;

use App\DTO\Game\{GamePartialDTO, GameDTO};

interface GameRepositoryInterface
{
    /**
     * @return GamePartialDTO[]
     */
    public function getAll(): array;

    /**
     * @return GameDTO
     */
    public function getById(int $id): GameDTO;
}