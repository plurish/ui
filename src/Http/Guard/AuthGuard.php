<? declare(strict_types=1);

namespace App\Http\Guard;

use App\DTO\Request\SignInRequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator as Authenticator;

class AuthGuard extends Authenticator
{
    use TargetPathTrait;

    private readonly string $loginApiUrl;
    private readonly string $loginPageUrl;

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly SerializerInterface $serializer,
    ) {
        $this->loginApiUrl = $urlGenerator->generate('api.auth.signin');
        $this->loginPageUrl = $urlGenerator->generate('auth.signin');
    }

    public function authenticate(Request $request): Passport
    {
        /** @var SignInRequestDTO */
        $form = $this->serializer->deserialize(
            $request->getContent(),
            SignInRequestDTO::class,
            'json'
        );

        /* TODO: 
            - usar o ValidatorInterface, para validar request body 
            - verificar se usuário autenticado está inativo
        */

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $form->username);

        return new Passport(
            new UserBadge($form->username),
            new PasswordCredentials($request->request->get('password', '')),
            $form->rememberMe ? [new RememberMeBadge()] : []
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $targetPath = $this->getTargetPath($request->getSession(), $firewallName);

        return new RedirectResponse($targetPath ?? $this->urlGenerator->generate('home.index'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ($request->hasSession())
            $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);

        // TODO: tratar mensagem de erro

        return new RedirectResponse($this->loginPageUrl);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->loginPageUrl);
    }

    public function getLoginUrl(Request $request): string
    {
        return $this->loginApiUrl;
    }
}
