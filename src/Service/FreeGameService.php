<? declare(strict_types=1);

namespace App\Service;

use App\Factory\ResponseFactory;
use App\Repository\Interface\GameRepositoryInterface;
use App\Service\Interface\GameServiceInterface;
use App\DTO\Response\ResponseDTO;
use App\DTO\Game\GamePartialDTO;
use Psr\Log\LoggerInterface;

class FreeGameService implements GameServiceInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly GameRepositoryInterface $gameRepository
    ) {
    }

    /**
     * @return ResponseDTO<GamePartialDTO>
     */
    public function get(?int $max, string $traceId): ResponseDTO
    {
        try {
            $games = $this->gameRepository->getAll();

            if ($max)
                $games = array_slice($games, 0, $max);

            shuffle($games);

            return ResponseFactory::ok(data: $games);
        } catch (\Exception $ex) {
            $this->logger->error('[GameService.getAll] - {exception} - TraceID: {traceId}', [
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }

    public function getById(int $id, string $traceId): ResponseDTO
    {
        try {
            $game = $this->gameRepository->getById($id);

            return ResponseFactory::ok(data: $game);
        } catch (\Exception $ex) {
            $this->logger->error('[GameService.getAll] - {exception} - TraceID: {traceId}', [
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }
}