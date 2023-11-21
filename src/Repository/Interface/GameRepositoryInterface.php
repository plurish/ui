<? declare(strict_types=1);

namespace App\Repository\Interface;

use App\DTO\Game\GamePartialDTO;

interface GameRepositoryInterface
{
    /**
     * @return GamePartialDTO[]
     */
    public function getAll(): array;
}