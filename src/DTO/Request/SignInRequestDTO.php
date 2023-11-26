<? declare(strict_types=1);

namespace App\DTO\Request;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\{NotBlank, Length};

class SignInRequestDTO
{
    public function __construct(
    #[NotBlank(message: 'O username deve ser preenchido')]
    #[Length(
        min: 2,
        max: 50,
        minMessage: 'O username deve conter, ao menos, 2 caracteres',
        maxMessage: 'O username deve conter, ao máximo, 50 caracteres'
    )]
        public readonly string $username,

    #[NotBlank(message: 'A senha deve ser preenchida')]
    #[Length(min: 2, minMessage: 'A senha não pode conter menos de 4 caracteres')]
        public readonly string $password,

    #[SerializedName('remember_me')]
        public readonly bool $rememberMe,
    ) {
    }
}