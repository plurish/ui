<? declare(strict_types=1);

namespace App\Mapper;

use App\Dto\Request\UserRequestDto;
use App\Dto\User\UserDto;
use App\Dto\User\UserPartialDto;
use App\Entity\UserEntity;

class UserMapper
{
    public static function entityToPartialDto(UserEntity $entity): UserPartialDto
    {
        return new UserPartialDto(
            $entity->getId(),
            $entity->getUsername(),
            $entity->getEmail(),
            $entity->getRoles()
        );
    }

    public static function entityToDto(UserEntity $entity): UserDto
    {
        return new UserDto(
            $entity->getId(),
            $entity->getUsername(),
            $entity->getEmail(),
            $entity->isActive(),
            $entity->getRoles()
        );
    }

    /**
     * Converts user entities to sanitized user Dtos
     * 
     * @param UserEntity[] $entities
     * @return UserPartialDto[]
     */
    public static function entitiesToPartialDtos(array $entities): array
    {
        return array_map(
            fn($entity) => self::entityToPartialDto($entity),
            $entities
        );
    }

    public static function requestToDto(UserRequestDto $user): UserDto
    {
        return new UserDto(
            0,
            $user->username,
            $user->email,
            $user->active,
            $user->roles
        );
    }
}