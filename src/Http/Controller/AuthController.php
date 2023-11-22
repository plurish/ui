<? declare(strict_types=1);

namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/auth')]
class AuthController extends BaseViewController
{
    #[Route('/signup', name: 'auth.signup', methods: ['GET'])]
    public function signup(): Response
    {
        return $this->inertia->render('Auth/SignUp');
    }

    #[Route('/signin', name: 'auth.signin', methods: ['GET'])]
    public function signin(AuthenticationUtils $authUtils): Response
    {
        if ($this->getUser())
            return $this->redirectToRoute('home.index');

        return $this->inertia->render('Auth/SignIn');
    }
}