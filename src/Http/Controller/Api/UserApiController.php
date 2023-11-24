<? declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Mapper\UserMapper;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use App\DTO\Request\UserRequestDTO;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Interface\UserServiceInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route('/api/user')]
class UserApiController extends BaseApiController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
        private readonly UserServiceInterface $userService,
    ) {
    }

    #[Route('/', name: 'api.user.get', methods: ['GET'])]
    public function get(#[MapQueryParameter] ?int $limit): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.user.get] - BEGIN - TraceID: {traceId}', ['traceId' => $traceId]);

        $response = $this->userService->get($limit, $traceId);

        $this->logger->debug('[api.user.get] - END - Response: {response} - TraceID: {traceId}', [
            'traceId' => $traceId,
            'response' => $this->serializer->serialize($response, 'json')
        ]);

        return $this->response($response);
    }

    #[Route('/{id}', name: 'api.user.getOne', methods: ['GET'])]
    public function getOne(int $id, #[MapQueryString] ?string $username, #[MapQueryString] ?string $email): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.user.getOne] - BEGIN - UserID: {id}. TraceID: {traceId}', [
            'id' => $id,
            'traceId' => $traceId,
        ]);

        $response = $this->userService->getOne($id, $username, $email, $traceId);

        $this->logger->debug('[api.user.getOne] - END - Response: {response} - TraceID: {traceId}', [
            'response' => $this->serializer->serialize($response, 'json'),
            'traceId' => $traceId,
        ]);

        return $this->response($response);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'api.user.create', methods: ['POST'])]
    public function create(#[MapRequestPayload] UserRequestDTO $request): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.user.create] - BEGIN - Request: {request}. TraceID: {traceId}', [
            'request' => $this->serializer->serialize($request, 'json'),
            'traceId' => $traceId,
        ]);

        $response = $this->userService->create(
            UserMapper::requestToDTO($request),
            $request->password,
            $traceId
        );

        $this->logger->debug('[api.user.create] - END - Response: {response} - TraceID: {traceId}', [
            'response' => $this->serializer->serialize($response, 'json'),
            'traceId' => $traceId,
        ]);

        return $this->response($response);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'api.user.update', methods: ['PATCH'])]
    public function update(#[MapRequestPayload] UserRequestDTO $request): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.user.update] - BEGIN - Request: {request}. TraceID: {traceId}', [
            'request' => $this->serializer->serialize($request, 'json'),
            'traceId' => $traceId,
        ]);

        $response = $this->userService->update($request, $traceId);

        $this->logger->debug('[api.user.update] - END - Response: {response} - TraceID: {traceId}', [
            'response' => $this->serializer->serialize($response, 'json'),
            'traceId' => $traceId,
        ]);

        return $this->response($response);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'api.user.destroy', methods: ['DELETE'])]
    public function destroy(int $id): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.user.destroy] - BEGIN - ID: {id}. TraceID: {traceId}', [
            'id' => $id,
            'traceId' => $traceId,
        ]);

        $response = $this->userService->delete($id, $traceId);

        $this->logger->debug('[api.user.destroy] - END - Response: {response} - TraceID: {traceId}', [
            'response' => $this->serializer->serialize($response, 'json'),
            'traceId' => $traceId,
        ]);

        return $this->response($response);
    }
}