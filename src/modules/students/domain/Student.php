<?php

namespace modules\students\domain;

use modules\shared\domain\Entity;
use modules\shared\domain\fields\Firstname;
use modules\shared\domain\fields\MaternalSurname;
use modules\shared\domain\fields\PaternalSurname;

final class Student extends Entity
{
    public function __construct(string $paternal_surname = null, string $maternal_surname = null, string $firstname = null, string $student_code = null, string $email = null)
    {
        parent::__construct(
            [
                'paternal surname' => new PaternalSurname( $paternal_surname ),
                'maternal surname' => new MaternalSurname( $maternal_surname ),
                'firstname' => new Firstname( $firstname ),
                'code' => new StudentCode( $student_code ),
                'email' => new StudentEmail($email)
            ]
        );
    }

    public static function create(array $data): Student
    {
        return new Student(
            $data['paternal surname'] ?? null,
            $data['maternal surname'] ?? null,
            $data['firstname'] ?? null,
            $data['student code'] ?? null,
            $data['email'] ?? null
        );
    }
}