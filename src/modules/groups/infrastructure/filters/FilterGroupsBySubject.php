<?php

namespace modules\groups\infrastructure\filters;

use Error;
use modules\groups\domain\Classroom;
use modules\groups\domain\Subject;
use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\criteria\Filter;

final class FilterGroupsBySubject
{
    public static function of(string $input = null): Filter
    {
        $property = new Subject( $input );
        if (!$property->valid()) {
            throw new Error($property->error());
        }

        $search = mb_strtoupper($property['value']);

        return Filter::of( "upper(Aula_Turno)", 'like', "%$search%" );
    }
}