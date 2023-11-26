<? declare(strict_types=1);

namespace App\Service;

use App\DTO\User\UserDTO;
use App\Entity\UserEntity;
use App\Mapper\UserMapper;
use Psr\Log\LoggerInterface;
use App\Factory\ResponseFactory;
use App\DTO\Response\ResponseDTO;
use App\Service\Interface\UserServiceInterface;
use App\Repository\Interface\UserRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function get(?int $limit, string $traceId): ResponseDTO
    {
        try {
            if ($limit != null && $limit < 1)
                return ResponseFactory::unprocessableEntity('Não é possível buscar ' . $limit . ' usuários');

            $users = $this->userRepository->findBy([], limit: $limit);

            return ResponseFactory::ok(
                data: UserMapper::entitiesToPartialDTOs($users)
            );
        } catch (\Exception $ex) {
            $this->logger->error('[UserService.get] - {exception} - TraceID: {traceId}', [
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }

    public function getOne(?int $id, ?string $username, ?string $email, string $traceId): ResponseDTO
    {
        try {
            $user = $this->userRepository->find($id);

            if (!$user)
                return ResponseFactory::noContent();

            $dto = UserMapper::entityToDTO($user);

            return ResponseFactory::ok(data: $dto);
        } catch (\Exception $ex) {
            $this->logger->error('[UserService.getOne] - Parameters: {params}. Exception {exception} - TraceID: {traceId}', [
                'params' => $id . '-' . $username . '-' . $email,
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }

    public function create(UserDTO $user, string $plainPassword, string $traceId): ResponseDTO
    {
        try {
            $emailAndUsernameAvailable = $this->userRepository->getOne(
                $user->username,
                $user->email
            ) === null;

            if (!$emailAndUsernameAvailable)
                return ResponseFactory::unprocessableEntity('Username e/ou e-mail já em uso');

            $user = new UserEntity(
                $user->username,
                $user->email,
                $plainPassword,
                active: $user->active,
            );

            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

            $result = $this->userRepository->create(
                $user->setPassword($hashedPassword)
            );

            return ResponseFactory::created('Cadastro realizado com sucesso!', $result);
        } catch (\Exception $ex) {
            $this->logger->error('[UserService.store] - User: {user}. Exception: {exception} - TraceID: {traceId}', [
                'user' => $this->serializer->serialize($user, 'json'),
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }

    public function update(UserDTO $user, string $traceId): ResponseDTO
    {
        try {
            $entity = $this->userRepository->getOne($user->username, $user->email);

            if (!$entity)
                return ResponseFactory::unprocessableEntity('Usuário não encontrado');

            $entity
                ->setActive($user->active)
                ->setRoles($user->roles);

            $result = $this->userRepository->update($entity);

            return ResponseFactory::ok('Alteração realizada com sucesso!', $result);
        } catch (\Exception $ex) {
            $this->logger->error('[UserService.update] - User: {user}. Exception: {exception} - TraceID: {traceId}', [
                'user' => $this->serializer->serialize($user, 'json'),
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }

    public function delete(int $id, string $traceId): ResponseDTO
    {
        try {
            // TODO: BARRAR DELEÇÃO DE SI PRÓPRIO

            $result = $this->userRepository->delete($id);

            return ResponseFactory::ok('Deleção realizada com sucesso!', $result);
        } catch (\Exception $ex) {
            $this->logger->error('[UserService.store] - ID: {id}. Exception: {exception} - TraceID: {traceId}', [
                'id' => $id,
                'exception' => $ex,
                'traceId' => $traceId
            ]);

            return ResponseFactory::internalServerError();
        }
    }
}