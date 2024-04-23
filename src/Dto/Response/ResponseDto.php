<? declare(strict_types=1);

namespace App\Dto\Response;

/** A response wrapper for the API responses */
class ResponseDto
{
    /** 
     * Preferably instantiated by App\Factory\ResponseFactory 
     * 
     * @param int $status HTTP status code
     * @param ?string $message Specify details about the response
     * @param T|null $data
     * 
     * @return ResponseDto<T|null>
     */
    public function __construct(
        public readonly int $status,
        public readonly ?string $message = '',
        public readonly mixed $data = null
    ) {
    }
}