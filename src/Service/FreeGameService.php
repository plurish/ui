<? declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;
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

    public function get(?int $limit, string $traceId): ResponseDTO
    {
        try {
            $games = $this->gameRepository->getAll();

            shuffle($games);

            if ($limit)
                $games = array_slice($games, 0, $limit);

            return ResponseFactory::ok(data: $games);
        } catch (\Exception $ex) {
            $this->logger->error('[GameService.get] - {exception} - TraceID: {traceId}', [
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }

    public function getWithCategories(string $traceId): ResponseDTO
    {
        try {
            /** @var array */
            $games = ($this->get(60, $traceId))?->data;

            $ads = $this->gameRepository->getAds();

            return ResponseFactory::ok(data: [
                'advertisements' => $ads,
                'populars' => array_slice($games, 0, 15),
                'trendings' => array_slice($games, 15, 15),
                'recommendeds' => array_slice($games, 30, 15),
                'new_releases' => array_slice($games, 45, 15),
            ]);
        } catch (\Exception $ex) {
            $this->logger->error('[GameService.getWithCategories] - {exception} - TraceID: {traceId}', [
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