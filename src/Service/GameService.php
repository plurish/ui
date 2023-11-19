<? declare(strict_types=1);

namespace App\Service;

class GameService
{
    public function getAll(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'God of War III'
            ]
        ];
    }
}