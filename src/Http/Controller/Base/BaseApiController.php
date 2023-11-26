<? declare(strict_types=1);

namespace App\Http\Controller\Base;

use App\DTO\Response\ResponseDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController extends AbstractController
{
    protected function response(object|array $data): Response
    {
        return $this->json($data, $data instanceof ResponseDTO ? $data->status : 200);
    }
}