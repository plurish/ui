<? declare(strict_types=1);

namespace App\DTO\Response;

/** A response wrapper for the API responses */
class ResponseDTO
{
    /** 
     * Preferably instantiated by App\Factory\ResponseFactory 
     * 
     * @param int $status HTTP status code
     * @param ?string $message Specify details about the response
     * @param T|null $data
     * 
     * @return ResponseDTO<T|null>
     */
    public function __construct(
        public readonly int $status,
        public readonly ?string $message = '',
        public readonly mixed $data = null
    ) {
    }
}