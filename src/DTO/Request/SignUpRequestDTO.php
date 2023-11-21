<? declare(strict_types=1);

namespace App\DTO\Request;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsFalse;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SignUpRequestDTO
{
    public function __construct(
    #[NotBlank('O username deve ser preenchido')]
    #[Length(min: 2, max: 50, message: 'O username deve conter entre 2 e 50 caracteres')]
        public readonly string $username,

    #[NotBlank('O e-mail deve ser preenchido')]
    #[Email(message: 'Endereço de e-mail inválido')]
        public readonly string $email,

    #[NotBlank('A senha deve ser preenchida')]
    #[Length(min: 2, message: 'A senha não pode conter menos de 4 caracteres')]
        public readonly string $password,

    #[SerializedName('password_confirmation')]
    #[NotBlank('A confirmação de senha deve ser preenchida')]
        public readonly string $passwordConfirmation,

    #[SerializedName('accept_terms')]
    #[IsFalse(message: 'Não é possível se cadastrar sem aceitar os termos de uso')]
        public readonly bool $acceptTerms,
    ) {
    }
}