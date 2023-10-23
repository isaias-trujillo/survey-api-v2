<?php

namespace modules\auth\application;

use Error;
use modules\auth\domain\AuthRepository;
use modules\auth\domain\User;

final class LoginStudent
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $username, string $password): array
    {
        $user = new User( $username, $password );
        if (!$user->valid()) {
            return [ 'errors' => $user->errors() ];
        }

        try {
            return [ 'authenticated' => $this->repository->login( $user ) ];
        } catch (Error $error) {

            return [ 'error' => $error->getMessage() ];
        }
    }
}