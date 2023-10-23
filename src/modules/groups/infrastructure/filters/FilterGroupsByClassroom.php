<?php

namespace modules\groups\infrastructure\filters;

use Error;
use modules\groups\domain\Classroom;
use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\criteria\Filter;

final class FilterGroupsByClassroom
{
    public static function of(string $classroom = null): Filter
    {
        $property = new Classroom( $classroom );
        if (!$property->valid()) {
            throw new Error($property->error());
        }

        if ($property->is_none()){
            return Filter::of("Aula_Turno", 'not regexp', '([0-9]{3})|(Lab-[A-Z])|(400 D)');
        }

        $search = $property['value'];

        return Filter::of( "Aula_Turno", 'like', "%$search%" );
    }
}