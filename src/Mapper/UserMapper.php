<? declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Request\UserRequestDTO;
use App\DTO\User\UserDTO;
use App\DTO\User\UserPartialDTO;
use App\Entity\UserEntity;

class UserMapper
{
    public static function entityToPartialDTO(UserEntity $entity): UserPartialDTO
    {
        return new UserPartialDTO(
            $entity->getUsername(),
            $entity->getEmail(),
            $entity->getRoles()
        );
    }

    public static function entityToDTO(UserEntity $entity): UserDTO
    {
        return new UserDTO(
            $entity->getId(),
            $entity->getUsername(),
            $entity->getEmail(),
            $entity->isActive(),
            $entity->getRoles()
        );
    }

    /**
     * Converts user entities to sanitized user DTOs
     * 
     * @param UserEntity[] $entities
     * @return UserPartialDTO[]
     */
    public static function entitiesToPartialDTOs(array $entities): array
    {
        return array_map(
            fn($entity) => self::entityToPartialDTO($entity),
            $entities
        );
    }

    public static function requestToDTO(UserRequestDTO $user): UserDTO
    {
        return new UserDTO(
            0,
            $user->username,
            $user->email,
            $user->active,
            $user->roles
        );
    }
}