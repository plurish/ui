<? declare(strict_types=1);

namespace App\Http\Controller;

use App\Service\Interface\GameServiceInterface;
use Psr\Log\LoggerInterface;
use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class HomeController extends BaseViewController
{
    public function __construct(
        protected readonly InertiaInterface $inertia,
        protected readonly LoggerInterface $logger,
        private readonly GameServiceInterface $gameService,
    ) {
    }

    #[Route('/', name: 'home.index')]
    #[Route('/home', name: 'home.index (/home)')]
    public function index(): Response
    {
        $games = $this->gameService->get(70, Uuid::v4()->toRfc4122());

        return $this->inertia
            ->render('Home', ['games' => $games?->data])
            ->setStatusCode($games->status);
    }
}
