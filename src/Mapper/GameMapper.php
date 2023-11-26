<? declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Game\GameDTO;
use App\DTO\Game\GamePartialDTO;
use App\DTO\Game\SystemRequirementsDTO;
use App\Repository\FreeGameRepository;
use DateTime;

class GameMapper
{
    /**
     * Converts one FreeToGame API game to a GamePartialDTO
     */
    public static function freePartialToStandardPartial(
        array $freeGame,
        string $descriptionProp = 'short_description'
    ): GamePartialDTO {
        $baseUrl = FreeGameRepository::BASE_URL;

        $videos = [
            $baseUrl . '/g/' . $freeGame['id'] . '/videoplayback.webm',
            $baseUrl . '/g/' . $freeGame['id'] . '/videoplayback.mp4',
        ];

        $backgroundImage = $baseUrl . '/g/' . $freeGame['id'] . '/background.jpg';

        return new GamePartialDTO(
            $freeGame['id'],
            $freeGame['title'],
            $freeGame['thumbnail'],
            $backgroundImage,
            $freeGame[$descriptionProp],
            $freeGame['genre'],
            $freeGame['publisher'],
            $freeGame['developer'],
            $freeGame['platform'],
            $videos
        );
    }

    /**
     * Converts an array of FreeToGame API games to an array of GamePartialDTO
     * 
     * @return GamePartialDTO[]
     */
    public static function freePartialsToStandardPartials(array $freeGames): array
    {
        return array_map(
            fn($freeGame) => self::freePartialToStandardPartial($freeGame),
            $freeGames
        );
    }

    /**
     * Converts a complete FreeToGame Game to a GameDTO
     */
    public static function freeToStandard(array $freeGame): GameDTO
    {
        // TODO: simplificar processo de build do Game/GamePartial
        $partialGame = self::freePartialToStandardPartial($freeGame, 'description');

        $minSysRequirements = $freeGame['minimum_system_requirements'];

        $sysReqs = new SystemRequirementsDTO(
            $minSysRequirements['os'],
            $minSysRequirements['processor'],
            $minSysRequirements['memory'],
            $minSysRequirements['graphics'],
            $minSysRequirements['storage'],
        );

        $screenshots = array_map(
            fn($screenshot) => $screenshot['image'],
            $freeGame['screenshots']
        );

        return self::partialToFull($partialGame, [
            'game_url' => $freeGame['game_url'],
            'release_date' => DateTime::createFromFormat('Y-m-d', $freeGame['release_date']),
            'sys_requirements' => $sysReqs,
            'screenshots' => $screenshots,
        ]);
    }

    /** Converts a GamePartialDTO to GameDTO */
    public static function partialToFull(GamePartialDTO $partial, array $complement): GameDTO
    {
        return new GameDTO(
            $partial->id,
            $partial->title,
            $partial->cover,
            $partial->backgroundImage,
            $partial->description,
            $partial->genre,
            $partial->publisher,
            $partial->developer,
            $partial->platform,
            $partial->videos,
            $complement['game_url'],
            $complement['release_date'],
            $complement['sys_requirements'],
            $complement['screenshots'],
        );
    }
}