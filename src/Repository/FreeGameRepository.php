<? declare(strict_types=1);

namespace App\Repository;

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
}