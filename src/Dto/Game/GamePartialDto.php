<? declare(strict_types=1);

namespace App\Dto\Game;

use Symfony\Component\Serializer\Annotation\SerializedName;

class GamePartialDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $cover,

        #[SerializedName('background_image')]
        public readonly ?string $backgroundImage,
        public readonly string $description,
        public readonly string $genre,
        public readonly string $publisher,
        public readonly string $developer,
        public readonly string $platform,
        public readonly array $videos
    ) {
    }
}