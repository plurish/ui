<? declare(strict_types=1);

namespace App\Dto\Game;

use Symfony\Component\Serializer\Annotation\SerializedName;

class GameDto extends GamePartialDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $cover,
        public readonly ?string $backgroundImage,
        public readonly string $description,
        public readonly string $genre,
        public readonly string $publisher,
        public readonly string $developer,
        public readonly string $platform,
        public readonly array $videos,
        #[SerializedName('game_url')]
        public readonly string $gameUrl,

        #[SerializedName('release_date')]
        public readonly \DateTime $releaseDate,

        #[SerializedName('sys_requirements')]
        public readonly ?SystemRequirementsDto $sysRequirements,

        /** @var string[] */
        public readonly array $screenshots,
    ) {
    }
}