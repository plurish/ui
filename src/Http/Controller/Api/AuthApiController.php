<? declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\DTO\Request\SignUpRequestDTO;
use App\Http\Controller\Api\BaseApiController;
use App\Service\Interface\AuthServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[Route('/api/auth')]
class AuthApiController extends BaseApiController
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route('/signup', name: 'api.auth.signup', methods: ['POST'])]
    public function signup(#[MapRequestPayload] SignUpRequestDTO $request): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $this->logger->debug('[api.auth.signup] - BEGIN - Username: {username}. Email: {email} - TraceID: {traceId}', [
            'username' => $request->username,
            'email' => $request->email,
            'traceId' => $traceId
        ]);

        $response = $this->authService->signup($request, $traceId);

        $this->logger->debug('[api.auth.signup] - END - Response: {response} - TraceID: {traceId}', [
            'response' => $this->serializer->serialize($response, 'json'),
            'traceId' => $traceId
        ]);

        return $this->response($response);
    }

    #[Route('/signin', name: 'api.auth.signin', methods: ['POST'])]
    public function signin()
    {
    }

    #[Route('/signout', name: 'api.auth.signout', methods: ['DELETE'])]
    public function signout()
    {
    }

    #[Route('/whoami', name: 'api.auth.whoami', methods: ['GET'])]
    public function whoami(Request $request): Response
    {
        $response = $this->authService->getAuthenticatedUser($request);

        return $this->response($response);
    }
}