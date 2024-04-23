<? declare(strict_types=1);

namespace App\Dto\Game;

class SystemRequirementsDto
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