<? declare(strict_types=1);

namespace App\Service;

use App\DTO\Request\SignUpRequestDTO;
use App\DTO\Response\ResponseDTO;
use App\DTO\UserDTO;
use App\Entity\UserEntity;
use App\Factory\ResponseFactory;
use App\Repository\UserRepository;
use App\Service\Interface\AuthServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ValidatorInterface $validator,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
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

            $emailAndUsernameAvailable = $this->userRepository->getOne(
                $request->username,
                $request->email
            ) === null;

            if (!$emailAndUsernameAvailable)
                return ResponseFactory::unprocessableEntity('Username e/ou endereço de e-mail já em uso');

            $user = new UserEntity(
                $request->username,
                $request->email,
                $request->password,
                active: true,
            );

            $user->setPassword($this->passwordHasher->hashPassword($user, $request->password));

            $result = $this->userRepository->create($user);

            return ResponseFactory::ok('Cadastro realizado com sucesso!', $result);
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
        $sessionUser = $request->getSession()->get(SecurityRequestAttributes::LAST_USERNAME);

        $user = new UserDTO(
            $sessionUser['id'] ?? 0,
            $sessionUser['username'] ?? 'guest',
            $sessionUser['email'] ?? '',
            $sessionUser['roles'] ?? [],
        );

        return ResponseFactory::ok(data: $user);
    }
}