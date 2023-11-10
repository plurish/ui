<? declare(strict_types=1);

namespace App\Http\Controller;

use Psr\Log\LoggerInterface;
use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseViewController extends AbstractController
{
    public function __construct(
        protected readonly InertiaInterface $inertia,
        protected readonly LoggerInterface $logger,
    ) {
    }
}
