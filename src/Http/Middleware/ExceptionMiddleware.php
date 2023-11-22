<? declare(strict_types=1);

namespace App\Http\Middleware;

use App\Factory\ResponseFactory;
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

        if (strpos($request->getRequestUri(), 'api')) {
            $responseContent = $this->serializer->serialize(
                ResponseFactory::internalServerError('Desculpe! Um erro inesperado ocorreu'),
                'json'
            );

            $response = $event->getResponse() ?? new Response();

            $response
                ->setContent($responseContent)
                ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

            $event->setResponse($response);
        }
    }
}