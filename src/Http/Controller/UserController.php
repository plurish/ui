<? declare(strict_types=1);

namespace App\Http\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Interface\UserServiceInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Http\Controller\Base\BaseViewController;
use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends BaseViewController
{
    public function __construct(
        protected readonly InertiaInterface $inertia,
        protected readonly LoggerInterface $logger,
        private readonly UserServiceInterface $userService,
    ) {
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/user', name: 'admin.user.index', methods: ['GET'])]
    public function index(): Response
    {
        $traceId = Uuid::v4()->toRfc4122();

        $result = $this->userService->get(null, $traceId);

        return $this->inertia->render('Admin/User/Index', [
            'users' => $result->data
        ]);
    }
}