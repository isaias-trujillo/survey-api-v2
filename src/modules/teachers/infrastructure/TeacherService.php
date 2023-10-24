<?php

namespace modules\teachers\infrastructure;

use modules\teachers\application\FindTeacherByDNI;
use modules\teachers\domain\DNI;

final class TeacherService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new MySqlTeacherTeacherRepository();
    }

    function find(string $dni = null): array
    {
        $dni = new DNI($dni);
        $finder = new FindTeacherByDNI( $this->repository );
        return $finder( $dni );
    }
}