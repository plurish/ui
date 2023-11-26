<? declare(strict_types=1);

namespace App\Service;

use App\Entity\UserEntity;
use Psr\Log\LoggerInterface;
use App\Factory\ResponseFactory;
use App\DTO\User\UserPartialDTO;
use App\DTO\Response\ResponseDTO;
use App\DTO\Request\SignUpRequestDTO;
use App\DTO\User\UserDTO;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Interface\AuthServiceInterface;
use App\Service\Interface\UserServiceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ValidatorInterface $validator,
        private readonly UserServiceInterface $userService,
        private readonly TokenStorageInterface $tokenStorage,
    ) {
    }

    public function signup(SignUpRequestDTO $request, string $traceId): ResponseDTO
    {
        try {
            $validationErrors = $this->validator->validate($request);

            if (count($validationErrors))
                return ResponseFactory::unprocessableEntity((string) $validationErrors);

            $passwordMatches = $request->password === $request->passwordConfirmation;

            if (!$passwordMatches)
                return ResponseFactory::unprocessableEntity('A senha deve ser confirmada corretamente');

            $user = new UserDTO(0, $request->username, $request->email, true);

            return $this->userService->create($user, $request->password, $traceId);
        } catch (\Exception $ex) {
            $this->logger->error('[AuthService.signup] - {exception} - TraceID: {traceId}', [
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError('Oops! Algo deu errado ao tentar realizar o cadastro');
        }
    }

    public function getAuthenticatedUser(Request $request): ResponseDTO
    {
        /** @var UserEntity */
        $user = $this->tokenStorage->getToken()?->getUser();

        if (!$user)
            return ResponseFactory::unauthorized('Usuário não autenticado');

        return ResponseFactory::ok(
            'Usuário está autenticado corretamente',
            new UserPartialDTO(
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                $user->getRoles()
            )
        );
    }
}