<?php

namespace modules\groups\infrastructure;

use Error;
use modules\groups\domain\Group;
use modules\groups\domain\GroupRepository;
use modules\shared\domain\criteria\Criteria;
use modules\shared\infrastructure\MySqlRepository;
use modules\shared\infrastructure\queries\Select;
use modules\teachers\domain\Teacher;

class MySqlGroupRepository extends MySqlRepository implements GroupRepository
{
    function match(Criteria $criteria): array
    {
        $query = "select Aula_Turno as 'group', DO_Nombre as 'full name', contrasena as 'dni' from dataalumno %conditions group by Aula_Turno, contrasena %order_by %pagination";
        $sql = $criteria->sql( $query );
        $request = new Select( $sql['query'], $sql['parameters'] );
        $PDO = $this->connect();

        if (!( $rows = $request->all( $PDO ) ) || empty( $rows )) {
            throw new Error( "No se encontró grupos que cumplan las condiciones dadas." );
        }

        return array_map( function (array $data) {
            $teacher = new Teacher( $data['full name'], $data['dni'] );
            return Group::raw( $data['group'], $teacher );
        }, $rows );
    }
}