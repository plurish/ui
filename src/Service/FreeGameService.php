<? declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\DTO\Game\GamePartialDTO;
use App\Factory\ResponseFactory;
use App\DTO\Response\ResponseDTO;
use App\Service\Interface\GameServiceInterface;
use App\Repository\Interface\GameRepositoryInterface;

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
    public function get(?int $limit, string $traceId): ResponseDTO
    {
        try {
            $games = $this->gameRepository->getAll();

            if ($limit)
                $games = array_slice($games, 0, $limit);

            shuffle($games);

            return ResponseFactory::ok(data: $games);
        } catch (\Exception $ex) {
            $this->logger->error('[GameService.get] - {exception} - TraceID: {traceId}', [
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
            $this->logger->error('[GameService.getById] - {exception} - TraceID: {traceId}', [
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }
}