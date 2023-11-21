<? declare(strict_types=1);

namespace App\DTO\Game;

use Symfony\Component\Serializer\Annotation\SerializedName;

class GameDTO extends GamePartialDTO
{
    public function __construct(
        int $id,
        string $title,
        string $cover,
        ?string $backgroundImage,
        string $description,
        string $genre,
        string $publisher,
        string $developer,
        string $platform,
        array $videos,
    #[SerializedName('game_url')]
        public readonly string $gameUrl,

    #[SerializedName('release_date')]
        public readonly \DateTime $releaseDate,

    #[SerializedName('sys_requirements')]
        public readonly SystemRequirementsDTO $sysRequirements,

        /** @var string[] */
        public readonly array $screenshots,
    ) {
        parent::__construct(
            $id,
            $title,
            $cover,
            $backgroundImage,
            $description,
            $genre,
            $publisher,
            $developer,
            $platform,
            $videos
        );
    }
}