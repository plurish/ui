<? declare(strict_types=1);

namespace App\Http\Middleware;

use App\Factory\ResponseFactory;
use App\Kernel;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\SerializerInterface;

#[AsEventListener(event: ExceptionEvent::class, method: 'onKernelException', priority: -10)]
class ExceptionMiddleware
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $this->logger->error('[ExceptionMiddleware] - {exception}', [
            'exception' => $exception,
        ]);

        $request = $event->getRequest();

        $isApiRequest = strpos($request->getRequestUri(), 'api');

        if ($isApiRequest) {
            // TODO: retornar status code específico da exception
            $errorMessage = $exception->getMessage();

            $responseContent = $this->serializer->serialize(
                ResponseFactory::internalServerError($errorMessage),
                'json'
            );

            $response = $event->getResponse() ?? new Response(status: Response::HTTP_INTERNAL_SERVER_ERROR);

            $response->setContent($responseContent);

            $event->setResponse($response);
        }
    }
}