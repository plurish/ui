<? declare(strict_types=1);

namespace App\Http\Guard;

use App\Dto\Request\SignInRequestDto;
use App\Entity\UserEntity;
use App\Factory\ResponseFactory;
use App\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator as Authenticator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthGuard extends Authenticator
{
    use TargetPathTrait;

    private readonly string $signinApiUrl;
    private readonly string $signinPageUrl;

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly TokenStorageInterface $tokenStorage,
    ) {
        $this->signinApiUrl = $urlGenerator->generate('api.auth.signin');
        $this->signinPageUrl = $urlGenerator->generate('auth.signin');
    }

    public function authenticate(Request $request): Passport
    {
        /** @var SignInRequestDto */
        $form = $this->serializer->deserialize(
            $request->getContent(),
            SignInRequestDto::class,
            'json'
        );

        $validationErrors = $this->validator->validate($request);

        if (count($validationErrors))
            throw new \Exception((string) $validationErrors, Kernel::CUSTOM_EXCEPTION_CODE);

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $form->username);

        return new Passport(
            new UserBadge($form->username),
            new PasswordCredentials($form->password),
            $form->rememberMe ? [new RememberMeBadge()] : []
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $targetPath = $this->getTargetPath($request->getSession(), $firewallName);

        /** @var UserEntity */
        $user = $token->getUser();

        // talvez substituir este if por um UserChecker: https://symfony.com/doc/current/security/user_checkers.html
        if (!$user->isActive())
            throw new \Exception('Conta de usuário inativa', Kernel::CUSTOM_EXCEPTION_CODE);

        return new RedirectResponse($targetPath ?? $this->urlGenerator->generate('home.index'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ($request->hasSession())
            $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);

        // TODO: tratar mensagem de erro
        $content = ResponseFactory::unauthorized($exception->getMessage());

        return new Response($this->serializer->serialize($content, 'json'), $content->status);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->signinPageUrl);
    }

    public function getLoginUrl(Request $request): string
    {
        return $this->signinApiUrl;
    }
}
