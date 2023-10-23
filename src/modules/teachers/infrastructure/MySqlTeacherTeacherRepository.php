<?php

namespace modules\teachers\infrastructure;

use Error;
use modules\shared\domain\criteria\Criteria;
use modules\shared\infrastructure\MySqlRepository;
use modules\shared\infrastructure\queries\Select;
use modules\teachers\domain\Teacher;
use modules\teachers\domain\TeacherRepository;

final class MySqlTeacherTeacherRepository extends MySqlRepository implements TeacherRepository
{
    function find(Criteria $criteria) : Teacher
    {
        $query = "select DO_Nombre as 'full name', contrasena as 'dni' from dataalumno %conditions %order_by %pagination";
        $sql = $criteria->sql($query);

        $request = new Select( $sql['query'], $sql['parameters'] );
        $PDO = $this->connect();

        if (!( $row = $request->one( $PDO ) ) || empty($row)) {
            throw new Error( "No se encontró al docente." );
        }
        return Teacher::from($row);
    }
}