<?php

namespace modules\students\infrastructure\filter;

use Error;
use modules\groups\domain\Subject;
use modules\shared\domain\criteria\Filter;
use modules\students\domain\StudentCode;

final class FilterStudentByCode
{
    public static function of(string $input = null): Filter
    {
        $property = new StudentCode( $input );
        if (!$property->valid()) {
            throw new Error($property->error());
        }

        $search = $property['value'];

        return Filter::of( "Codigo", '=', $search );
    }
}