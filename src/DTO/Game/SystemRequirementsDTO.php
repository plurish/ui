<? declare(strict_types=1);

namespace App\DTO\Game;

class SystemRequirementsDTO
{
    public function __construct(
        public readonly string $os,
        public readonly string $processor,
        public readonly string $memory,
        public readonly string $graphics,
        public readonly string $storage,
    ) {
    }
}