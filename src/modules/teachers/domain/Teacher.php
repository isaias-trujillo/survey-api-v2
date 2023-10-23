<?php

namespace modules\teachers\domain;

use modules\shared\domain\Entity;
use modules\shared\domain\fields\Firstname;
use modules\shared\domain\fields\FullName;
use modules\shared\domain\fields\MaternalSurname;
use modules\shared\domain\fields\PaternalSurname;
use modules\shared\domain\fields\Id;

final class Teacher extends Entity
{
    public function __construct(string $full_name = null, string $dni = null)
    {
        parent::__construct(
            [
                'full name' => new FullName($full_name),
                'dni' => new DNI( $dni ),
            ]
        );
    }

    public static function from(array $data): Teacher
    {
        return new Teacher(
            $data['full name'] ?? null,
            $data['dni'] ?? null
        );
    }
}