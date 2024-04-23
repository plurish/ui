<? declare(strict_types=1);

namespace App\Http\Controller\Base;

use App\Dto\Response\ResponseDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController extends AbstractController
{
    protected function response(object|array $data): Response
    {
        return $this->json($data, $data instanceof ResponseDto ? $data->status : 200);
    }
}