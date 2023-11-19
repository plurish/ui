<? declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Service\GameService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/game')]
class GameApiController extends BaseApiController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly GameService $gameService,
    ) {
    }

    #[Route('/', name: 'api.game.get', methods: ['GET'])]
    public function get(): Response
    {
        $traceId = uuid_create();

        $this->logger->debug('[api.game.get] - BEGIN - TraceID: {traceId}', ['traceId' => $traceId]);

        $games = $this->gameService->getAll();

        $this->logger->debug('[api.game.get] - END - Response: {games} - TraceID: {traceId}', [
            'traceId' => $traceId,
            'games' => $games
        ]);

        return $this->json($games);
    }
}