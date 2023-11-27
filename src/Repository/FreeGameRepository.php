<? declare(strict_types=1);

namespace App\Repository;

use App\DTO\Game\GameDTO;
use App\Mapper\GameMapper;
use App\Repository\Interface\GameRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FreeGameRepository implements GameRepositoryInterface
{
    public const BASE_URL = 'https://www.freetogame.com';
    private readonly HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient->withOptions([
            'base_uri' => self::BASE_URL
        ]);
    }

    public function getAll(): array
    {
        $response = $this->httpClient->request(Request::METHOD_GET, '/api/games', [
            'query' => ['sort-by' => 'alphabetical']
        ]);

        return GameMapper::freePartialsToStandardPartials($response->toArray());
    }

    public function getAds(): array
    {
        $ads = [];

        $path = __DIR__ . '/Data/game-advertisements.php';

        if (file_exists($path))
            $ads = require_once($path);

        return $ads;
    }

    public function getById(int $id): GameDTO
    {
        $response = $this->httpClient->request(Request::METHOD_GET, '/api/game', [
            'query' => ['id' => $id]
        ]);

        $content = $response->toArray();

        return GameMapper::freeToStandard($content);
    }
}