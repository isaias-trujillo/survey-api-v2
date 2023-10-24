<?php

namespace modules\groups\infrastructure\filters;

use Error;
use modules\groups\domain\Classroom;
use modules\groups\domain\Subject;
use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\criteria\Filter;
use modules\shared\domain\fields\FullName;

final class FilterGroupsByTeacher
{
    public static function of(string $input = null): Filter
    {
        $property = new FullName( $input );
        if (!$property->valid()) {
            throw new Error($property->error());
        }

        $search = mb_strtoupper($property['value']);

        return Filter::of( "upper(DO_Nombre)", 'like', "%$search%" );
    }
}