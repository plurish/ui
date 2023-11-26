<? declare(strict_types=1);

namespace App\Http\Controller\Api;

use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controller\Base\BaseApiController;
use App\Service\Interface\GameServiceInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

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
    public function get(#[MapQueryParameter] ?int $limit): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.game.get] - BEGIN - TraceID: {traceId}', ['traceId' => $traceId]);

        $games = $this->gameService->get($limit, $traceId);

        $this->logger->debug('[api.game.get] - END - Response: {games} - TraceID: {traceId}', [
            'traceId' => $traceId,
            'games' => $this->serializer->serialize($games, 'json')
        ]);

        return $this->response($games);
    }

    #[Route('/{id}', name: 'api.game.getById', methods: ['GET'])]
    public function getById(int $id): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.game.getById] - BEGIN - ID: {id} - TraceID: {traceId}', [
            'traceId' => $traceId,
            'id' => $id
        ]);

        $response = $this->gameService->getById($id, $traceId);

        $this->logger->debug('[api.game.getById] - END - Response: {response} - TraceID: {traceId}', [
            'traceId' => $traceId,
            'response' => $this->serializer->serialize($response, 'json')
        ]);

        return $this->response($response);
    }
}