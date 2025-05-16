<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Repository\UserRepository;
use App\Model\User;

class AuthenticateUser
{
    /**
     * @var \App\Model\Repository\UserRepository
     */
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @param string $email
     * @param string $password
     * @return \App\Model\User
     * @throws \Exception
     */
    public function execute(string $email, string $password): User
    {
        try {
            $user = $this->userRepository->getByEmail($email);
        } catch (\Exception $e) {
            throw new \Exception('Invalid login or password.');
        }
        try {
            $this->authenticate($user, $password);
        } catch (\Exception $e) {
            throw new \Exception('Invalid login or password.');
        }
        return $user;
    }

    /**
     * @param \App\Model\User $user
     * @param string $password
     * @return void
     * @throws \Exception
     */
    private function authenticate(User $user, string $password): void
    {
        if (!password_verify($password, $user->getPasswordHash())) {
            throw new \Exception('Invalid login or password.');
        }
    }
}
