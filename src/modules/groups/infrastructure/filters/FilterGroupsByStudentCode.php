<?php

namespace modules\groups\infrastructure\filters;

use Error;
use modules\shared\domain\criteria\Filter;
use modules\students\domain\StudentCode;

final class FilterGroupsByStudentCode
{
    public static function of(string $student_code): Filter
    {
        $code = new StudentCode( $student_code );

        if (!$code->valid()) {
            throw new Error( $code->error() );
        }


        return Filter::of( 'Codigo', '=', $student_code );
    }
}