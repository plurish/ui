<? declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Service\Interface\GameServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[Route('/api/game')]
class GameApiController extends BaseApiController
{
    public function __construct(
        private readonly GameServiceInterface $gameService,
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('/', name: 'api.game.get', methods: ['GET'])]
    public function get(#[MapQueryParameter] ?int $max): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.game.get] - BEGIN - TraceID: {traceId}', ['traceId' => $traceId]);

        $games = $this->gameService->get($max, $traceId);

        $this->logger->debug('[api.game.get] - END - Response: {games} - TraceID: {traceId}', [
            'traceId' => $traceId,
            'games' => $this->serializer->serialize($games, 'json')
        ]);

        return $this->response($games);
    }
}