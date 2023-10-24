<?php

namespace modules\auth\infrastructure;

use modules\auth\application\LoginStudent;

final class AuthService
{
    private $repository;
    public function __construct() {
        $this->repository = new MySqlAuthRepository();
    }

    function authenticate(string $username, string $password): array
    {
        $case = new LoginStudent($this->repository);
        return $case($username, $password);
    }
}