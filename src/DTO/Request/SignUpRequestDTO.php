<? declare(strict_types=1);

namespace App\DTO\Request;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\{NotBlank, Email, IsTrue, Length};

class SignUpRequestDTO
{
    public function __construct(
    #[NotBlank(message: 'O username deve ser preenchido')]
    #[Length(min: 2, max: 50, minMessage: 'O username deve conter, ao menos, 2 caracteres', maxMessage: 'O username deve conter, ao máximo, 50 caracteres')]
        public readonly string $username,

    #[NotBlank(message: 'O e-mail deve ser preenchido')]
    #[Email(message: 'Endereço de e-mail inválido')]
        public readonly string $email,

    #[NotBlank(message: 'A senha deve ser preenchida')]
    #[Length(min: 2, minMessage: 'A senha não pode conter menos de 4 caracteres')]
        public readonly string $password,

    #[NotBlank(message: 'A confirmação de senha deve ser preenchida')]
    #[SerializedName('password_confirmation')]
        public readonly string $passwordConfirmation,

    #[IsTrue(message: 'Não é possível se cadastrar sem aceitar os termos de uso')]
    #[SerializedName('terms_accepted')]
        public readonly bool $termsAccepted,
    ) {
    }
}