<? declare(strict_types=1);

namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseViewController
{
    #[Route('/', name: 'home.index')]
    #[Route('/home', name: 'home.index (/home)')]
    public function index(): Response
    {
        // TODO: get games from IGDB API

        return $this->inertia->render('Home');
    }
}
