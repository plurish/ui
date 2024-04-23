<? declare(strict_types=1);

namespace App\Repository\Interface;

use App\Dto\Game\{GamePartialDto, GameDto};

interface GameRepositoryInterface
{
    /**
     * @return GamePartialDto[]
     */
    public function getAll(): array;

    public function getAds(): array;

    /**
     * @return GameDto
     */
    public function getById(int $id): GameDto;
}