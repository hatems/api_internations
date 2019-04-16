<?php

namespace App\Service;
use App\Repository\UserRepository;
use App\Entity\User;

final class UserService
{


    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getUser(int $userId): ?User
    {
        return $this->userRepository->findOneById($userId);
    }

    public function getAllUsers(): ?array
    {
        return $this->userRepository->findAll();
    }

    public function addUser(string $name): User
    {
        $user = new User();
        $user->setName($name);
        $this->userRepository->save($user);
        return $user;
    }


    public function deleteUser(int $userId): bool
    {
        $user = $this->userRepository->findOneById($userId);
            if ($user) {
                $this->userRepository->delete($user);
                return true;
            }
            return false;
    }

}