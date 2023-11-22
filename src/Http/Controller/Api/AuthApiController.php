<? declare(strict_types=1);

namespace App\Http\Controller\Api;

use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use App\DTO\Request\SignUpRequestDTO;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controller\Api\BaseApiController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Interface\AuthServiceInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

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
        /* método vazio, pois o App\Http\Guard\AuthGuard intercepta 
           este endpoint e realiza a autenticação */
    }

    #[Route('/signout', name: 'api.auth.signout', methods: ['DELETE'])]
    public function signout()
    {
        /* método vazio, pois o symfony automaticamente limpa
         a session quando este endpoint é chamado, pelo modo como 
         foi configurado o config/packages/security.yaml */
    }

    #[Route('/whoami', name: 'api.auth.whoami', methods: ['GET'])]
    public function whoami(Request $request): Response
    {
        $response = $this->authService->getAuthenticatedUser($request);

        return $this->response($response);
    }
}