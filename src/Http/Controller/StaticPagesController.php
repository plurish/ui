<? declare(strict_types=1);

namespace App\Http\Controller;

use Psr\Log\LoggerInterface;
use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPagesController extends BaseViewController
{
    public function __construct(
        protected readonly InertiaInterface $inertia,
        protected readonly LoggerInterface $logger,
    ) {
    }

    #[Route('/landing', name: 'static-pages.landing')]
    public function landing(): Response
    {
        return $this->inertia->render('LandingPage');
    }
}
