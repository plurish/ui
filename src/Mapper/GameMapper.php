<? declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Game\GamePartialDTO;
use App\Repository\FreeGameRepository;

class GameMapper
{
    /**
     * Converts one FreeToGame API game to a GamePartialDTO
     */
    public static function freePartialToStandardPartial(array $freeGame): GamePartialDTO
    {
        $videos = [
            FreeGameRepository::BASE_URL . '/g/' . $freeGame['id'] . '/videplayback.webm',
            FreeGameRepository::BASE_URL . '/g/' . $freeGame['id'] . '/videplayback.mp4',
        ];

        return new GamePartialDTO(
            $freeGame['id'],
            $freeGame['title'],
            $freeGame['thumbnail'],
            $freeGame['short_description'],
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
}