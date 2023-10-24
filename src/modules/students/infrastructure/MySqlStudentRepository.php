<?php

namespace modules\students\infrastructure;

use Error;
use modules\shared\domain\criteria\Criteria;
use modules\shared\infrastructure\MySqlRepository;
use modules\shared\infrastructure\queries\Select;
use modules\students\domain\Student;
use modules\students\domain\StudentRepository;

final class MySqlStudentRepository extends MySqlRepository implements StudentRepository
{
    function find(Criteria $criteria): Student
    {
        $query = "select AL_Pater as 'paternal surname', AL_Mater as 'maternal surname', AL_Nombre as 'firstname', Codigo as 'student code', Correo as 'email' from dataalumno" . " %conditions %order_by %pagination ";
        $sql = $criteria->sql( $query );
        $request = new Select( $sql['query'], $sql['parameters'] );
        $PDO = $this->connect();

        if (!( $row = $request->one( $PDO ) ) || empty( $row )) {
            throw new Error( "No se encontró al estudiante con las condiciones dadas." );
        }

        return Student::create($row);
    }
}