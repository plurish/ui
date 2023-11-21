<? declare(strict_types=1);

namespace App\DTO\Game;

class GamePartialDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $cover,
        public readonly string $description,
        public readonly string $genre,
        public readonly string $publisher,
        public readonly string $developer,
        public readonly string $platform,
        public readonly array $videos
    ) {
    }
}