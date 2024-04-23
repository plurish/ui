<? declare(strict_types=1);

namespace App\Factory;

use App\Dto\Response\ResponseDto;
use Symfony\Component\HttpFoundation\Response;

/** An inflexible factory for the ResponseDto */
class ResponseFactory
{
    private static function create(int $status, ?string $message = '', mixed $data = null)
    {
        if (!array_key_exists($status, Response::$statusTexts))
            throw new \Exception('Invalid HTTP status code');

        return new ResponseDto($status, $message, $data);
    }

    // 200 - 299
    /**
     * @template T 'data' param type
     * @param ?string $message Specify details about the response
     * @param T|null $data
     * 
     * @return ResponseDto<T|null>
     */
    public static function ok(?string $message = '', mixed $data = null): ResponseDto
    {
        return self::create(Response::HTTP_OK, $message, $data);
    }

    /**
     * @template T 'data' param type
     * @param ?string $message Specify details about the response
     * @param T|null $data
     * 
     * @return ResponseDto<T|null>
     */
    public static function created(?string $message = '', mixed $data = null): ResponseDto
    {
        return self::create(Response::HTTP_CREATED, $message, $data);
    }

    /**
     * Returns a response without any content
     * 
     * @return ResponseDto<null>
     */
    public static function noContent(): ResponseDto
    {
        return self::create(Response::HTTP_NO_CONTENT);
    }

    // 400 - 499
    /**
     * @param ?string $message Specify details about the response
     * 
     * @return ResponseDto<null>
     */
    public static function unprocessableEntity(?string $message = ''): ResponseDto
    {
        return self::create(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }

    /**
     * @param ?string $message Specify details about the response
     * 
     * @return ResponseDto<null>
     */
    public static function badRequest(?string $message = ''): ResponseDto
    {
        return self::create(Response::HTTP_BAD_REQUEST, $message);
    }

    /**
     * @param ?string $message Specify details about the response
     * 
     * @return ResponseDto<null>
     */
    public static function unauthorized(?string $message = ''): ResponseDto
    {
        return self::create(Response::HTTP_UNAUTHORIZED, $message);
    }

    /**
     * @param ?string $message Specify details about the response
     * 
     * @return ResponseDto<null>
     */
    public static function forbidden(?string $message = ''): ResponseDto
    {
        return self::create(Response::HTTP_FORBIDDEN, $message);
    }

    /**
     * @param ?string $message Specify details about the response
     * 
     * @return ResponseDto<null>
     */// 500 - 599
    public static function internalServerError(?string $message = ''): ResponseDto
    {
        // TODO: aceitar exception, tratá-la e retornar sua mensagem
        return self::create(Response::HTTP_INTERNAL_SERVER_ERROR, $message);
    }
}