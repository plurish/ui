<? declare(strict_types=1);

namespace App\Mapper;

use App\Dto\Game\GameDto;
use App\Dto\Game\GamePartialDto;
use App\Dto\Game\SystemRequirementsDto;
use App\Repository\FreeGameRepository;
use DateTime;

class GameMapper
{
    /**
     * Converts one FreeToGame API game to a GamePartialDto
     */
    public static function freePartialToStandardPartial(
        array $freeGame,
        string $descriptionProp = 'short_description'
    ): GamePartialDto {
        $baseUrl = FreeGameRepository::BASE_URL;

        $videos = [
            $baseUrl . '/g/' . $freeGame['id'] . '/videoplayback.webm',
            $baseUrl . '/g/' . $freeGame['id'] . '/videoplayback.mp4',
        ];

        $backgroundImage = $baseUrl . '/g/' . $freeGame['id'] . '/background.jpg';

        return new GamePartialDto(
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
     * Converts an array of FreeToGame API games to an array of GamePartialDto
     * 
     * @return GamePartialDto[]
     */
    public static function freePartialsToStandardPartials(array $freeGames): array
    {
        return array_map(
            fn($freeGame) => self::freePartialToStandardPartial($freeGame),
            $freeGames
        );
    }

    /**
     * Converts a complete FreeToGame Game to a GameDto
     */
    public static function freeToStandard(array $freeGame): GameDto
    {
        // TODO: simplificar processo de build do Game/GamePartial
        $partialGame = self::freePartialToStandardPartial($freeGame, 'description');

        $minSysRequirements = array_key_exists('minimum_system_requirements', $freeGame)
            ? $freeGame['minimum_system_requirements']
            : null;

        $haveSisReqs = $minSysRequirements
            && array_key_exists('os', $minSysRequirements)
            && $minSysRequirements['os'];

        $sysReqs = $haveSisReqs ? new SystemRequirementsDto(
            $minSysRequirements['os'],
            $minSysRequirements['processor'],
            $minSysRequirements['memory'],
            $minSysRequirements['graphics'],
            $minSysRequirements['storage'],
        ) : null;

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

    /** Converts a GamePartialDto to GameDto */
    public static function partialToFull(GamePartialDto $partial, array $complement): GameDto
    {
        return new GameDto(
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