<?php

namespace modules\auth\domain;

use modules\shared\domain\Entity;
use modules\students\domain\StudentCode;
use modules\students\domain\StudentEmail;

final class User extends Entity
{
    public function __construct(string $email = null, string $student_code = null)
    {
        parent::__construct(
            [
                'username' => new StudentEmail($email),
                'password' => new StudentCode($student_code)
            ]
        );
    }

    public static function from(array $data): User
    {
        return new User(
            $data['username'] ?? null,
            $data['password'] ?? null
        );
    }
}