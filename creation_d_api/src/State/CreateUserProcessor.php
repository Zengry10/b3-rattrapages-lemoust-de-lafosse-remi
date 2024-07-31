<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Request\CreateUserRequest;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {}

    /**
     * @inheritDoc
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        if (!$data instanceof CreateUserRequest) {
            throw new LogicException(sprintf("Expected an instance of %s", CreateUserRequest::class));
        }

        $user = (new User())
            ->setUsername($data->username)
        ;

        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $data->password);

        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}